<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'image_id',
        'display_as_popular',
        'display_in_footer',
        'url_alias',
        'related_attribute_id',
        'parent_id',
        'sort_order',
        'status'
    ];

    protected $dates = ['deleted_at'];

    protected $table = 'categories';

    public function units()
    {
        return $this->belongsToMany('App\Models\Unit', 'unit_categories');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'product_category_id', 'id');
    }

    public function related_attributes()
    {
        return $this->hasMany('App\Models\AttributeValue', 'attribute_id', 'related_attribute_id');
    }

    public function image()
    {
        $image = $this->belongsTo('App\Models\Image');
        if(!$image->count()){
            $this->image_id = 1;
            $image = $this->belongsTo('App\Models\Image');
        }
        return $image;
    }

    public function children() {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id')->with('children');
    }

    public function parent() {
        return $this->belongsTo('App\Models\Category', 'parent_id', 'id');
    }

    public function parents() {
        return $this->belongsTo('App\Models\Category', 'parent_id', 'id')->with('parents');
    }

    public function getUrlAttribute(){
        return '/catalog/'.$this->attributes['url_alias'];
    }

    /**
     * ID всех вложенных категорий
     *
     * @return array
     */
    public function children_ids(){
        return $this->parse_children_ids($this->children()->get());
    }

    public function parse_children_ids($categories){
        $ids = [];
        foreach ($categories as $category){
            $ids[] = $category->id;
            if(!$category->children->isEmpty()){
                $ids = array_merge($ids, $this->parse_children_ids($category->children));
            }
        }

        return $ids;
    }

    /**
     * Получение массива родительских категорий
     *
     * @param string $category
     * @return array
     */
    public function get_parent_categories($category = ''){
        $categories = [];

        if(!empty($category)){
            if(is_numeric($category)){
                $category = $this->where('id', $category)->first();
            }elseif(is_string($category)){
                $category = $this->where('url_alias', $category)->first();
            }
        }else{
            $category = $this;
        }

        $categories[] = $category;
        if($category->parent_id > 0)
            $categories = array_merge($categories, $this->get_parent_categories($category->parent_id));

        return $categories;
    }

    /**
     * Получение категорий определённого уровня вложенности
     *
     * @param $id - уровень вложенности
     * @return null|object
     */
    public function level($id){

        $categories = Cache::remember('categories_level_'.$id, 60, function () use (&$id) {
            $parent_ids = [0];
            $categories = null;
            for($i = 0; $i < $id; $i++){
                $categories = $this->whereIn('parent_id', $parent_ids)->get();
                if($i+1 < $id){
                    $parent_ids = [];
                    foreach ($categories as $category){
                        $parent_ids[] = $category->id;
                    }
                }
            }

            return $categories;
        });

        return $categories;
    }

    public function popular($count = 4){
        return $this->where('status', 1)->where('display_as_popular', 1)->take($count)->orderBy('id', 'desc')->with('image')->get();
    }

    public function get_products($category_id, $filter, $capacity = [], $sort, $take = false)
    {

        if ($sort == 'popularity') {
            $orderBy = 'rating';
            $route = 'desc';
        } elseif ($sort == 'date') {
            $orderBy = 'updated_at';
            $route = 'desc';
        } elseif ($sort == 'name') {
            $orderBy = 'name';
            $route = 'asc';
        }

        $products = Product::select('products.*');

        if ($category_id == 'bestsellers') {
            $products->join('module_bestsellers', 'products.id', '=', 'module_bestsellers.product_id');
        } elseif ($category_id == 'new') {
            $products->join('module_new_products', 'products.id', '=', 'module_new_products.product_id');
        } elseif($category_id == 'sale') {
            $products->whereNotNull('sale');
        } elseif ($category_id) {
            $products->where('product_category_id', $category_id);
            $products->orderBy('products.label', 'asc');
            $products->orderBy('products.articul', 'asc');
        }

        if (!empty($filter)) {

            foreach ($filter as $key => $attribute) {

                $products->join('product_attributes AS attr' . $key, 'products.id', '=', 'attr' . $key . '.product_id');
                $products->where('stock', 1);
                $products->where('attr' . $key . '.attribute_id', $key);
                $products->where(function($query) use($attribute, $key){

                    foreach ($attribute as $attribute_value) {
                        $query->orWhere('attr' . $key . '.attribute_value_id', $attribute_value);
                    }
                });

            }
        }

        if(!empty($capacity)){
            $products->whereIn('capacity', $capacity);
        }

        $products->orderBy($orderBy, $route);
        $products->groupBy('products.id');
//dd($products->toSql());
        if (!$take) {
            return $products->paginate(24);
        } else {
            return $products->take($take)->inRandomOrder()->get();
        }

    }

}
