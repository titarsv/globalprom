<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Gallery;

class Products extends Model
{

    use SoftDeletes;

    protected $fillable =[
        'name',
        'excerpt',
        'description',
        'options',
        'sizes',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'robots',
        'url_alias',
        'articul',
        'price',
        'old_price',
        'product_category_id',
        'product_related_category_id',
        'image_id',
        'gallery_id',
        'photos_id',
        'action',
        'video',
        'stock',
        'rating',
        'label'
    ];

    protected $labels = [
        'z' => '-',
        'action' => 'АКЦИЯ',
        'dealer' => 'ДИЛЛЕР',
        'new' => 'НОВИНКА',
        'hit' => 'ХИТ продаж',
        'price' => 'ЦЕНА месяца'
    ];

    public function labels(){
        return $this->labels;
    }

    protected $table = 'products';
    protected $dates = ['deleted_at'];

    public function categories()
    {
        return $this->belongsToMany('App\Models\Categories', 'product_categories', 'product_id', 'category_id');
    }

    public function category()
    {
        return $this->hasOne('App\Models\Categories', 'id', 'product_category_id');
    }

    public function image()
    {
        return $this->hasOne('App\Models\Image', 'id', 'image_id');
    }

    public function attributes()
    {
        return $this->hasMany('App\Models\ProductAttributes', 'product_id');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\ProductsReview', 'product_id');
    }

    public function wishlist()
    {
        return $this->hasMany('App\Models\Wishlist', 'product_id');
    }

    public function products_cart()
    {
        return $this->hasOne('App\Models\ProductsCart', 'product_id');
    }

    public function gallery()
    {
        return $this->belongsTo('App\Models\Gallery');
    }

    public function photos()
    {
        return $this->belongsTo('App\Models\Gallery', 'photos_id');
    }

    // Наборы с этим товаром
    public function sets()
    {
        return $this->belongsToMany('App\Models\Products', 'product_sets', 'product_id', 'set_id');
    }

    // Товары в наборе
    public function set_products()
    {
        return $this->belongsToMany('App\Models\Products', 'product_sets', 'set_id', 'product_id');
    }

    // Вариации
    public function variations()
    {
        return $this->hasMany('App\Models\Variation', 'product_id');
    }

    // Связанные товары
    public function related()
    {
        return $this->belongsToMany('App\Models\Products', 'related_products', 'product_id', 'related_id');
    }

    // Сопутствующие товары
    public function similar()
    {
        return $this->belongsToMany('App\Models\Products', 'similar_products', 'product_id', 'similar_id');
    }

    /**
     * Поиск товаров
     * @param string $text Поисковый текст
     * @param int $page Номер страницы
     * @param int $count Колличество на странице
     * @return LengthAwarePaginator
     */
    public function search($text = '', $page = 1, $count = 8)
    {
        $search = explode(' ', $text);
        $results = $this->where('stock', 1);
        foreach($search as $s){
            $results->where('name', 'like', '%' . $s . '%');
        }
        $data = $results->paginate($count);

//        $data = $this->where('stock', 1)->where('name', 'like', '%'.$text.'%')->paginate($count);

        return $data;
    }

    public function create_product_thumnail($id)
    {
        $product = $this->find($id);

        $overlay = [];
        foreach ($product->get_attributes as $attribute) {
            $attribute_info = Attributes::find($attribute->attribute_id);

            if($attribute_info->enable_image_overlay) {
                $image = AttributeValues::find($attribute->attribute_value_id);

                $overlay[$attribute->attribute_id]['images'][] = $image->image_href;
                $overlay[$attribute->attribute_id]['settings'] = unserialize($attribute_info->image_overlay_settings);

            }
        }

        if (!empty($overlay)) {
            $image = new Image;
            $id = $image->create_thumbnail(public_path() . '/assets/images/' . $product->original_image->href, $overlay);

            $product->image_id = $id;
            $product->save();
        }
    }

    public function get_attributes()
    {
        return $this->hasMany('App\Models\ProductAttributes', 'product_id');
    }

    /**
     * Создание продукта
     * @param $data
     * @return string
     */
    public function insert_product($data)
    {
        if(!isset($data['products']['url_alias'])){
            $data['products']['url_alias'] = $this->generate_alias($data['products']);
        }

        if($this->isset_product_with_url_alias($data['products']['url_alias']) == false) {
            $result_data = $this->get_prepared_data($data);

            if(!empty($result_data['products']['id'])){
                $this->unguard();
            }

			if(!empty($result_data['galleries'])){
				$gallery = new Gallery();
				$result_data['products']['gallery_id'] = $gallery->add_gallery($result_data['galleries']);
			}

            if(!empty($result_data['photos'])){
                $gallery = new Gallery();
                $result_data['products']['photos_id'] = $gallery->add_gallery($result_data['photos']);
            }

            $id = $this->insertGetId($result_data['products']);
            $product = $this->find($id);
            if(!empty($result_data['product_attributes']))
                $product->attributes()->createMany($result_data['product_attributes']);

            if(!empty($result_data['categories']))
                $product->categories()->attach($result_data['categories']);

            //$product->create_product_thumnail($id);
            return $id;
        } else {
            return 'already_exist';
        }
    }

    /**
     * Обновление продукта
     * @param $data
     * @return string
     */
    public function update_product($data)
    {
        if(!isset($data['products']['url_alias'])){
            $data['products']['url_alias'] = $this->generate_alias($data['products']);
        }

        if($this->isset_product_with_url_alias($data['products']['url_alias']) == false) {
            $id = $this->insert_product($data);
        }else{
            $result_data = $this->get_prepared_data($data);

            $product = $this->select('id')
                ->where('url_alias', $data['products']['url_alias'])
                ->take(1)
                ->get()
                ->first();

            $id = $product->id;

            $this->where('id', $id)->update($result_data['products']);
            $product->description()->where('product_id', $id)->update($result_data['product_description']);
            $product->attributes()->where('product_id', $id)->delete();
            if (!empty($result_data['product_attributes']))
                $product->attributes()->createMany($result_data['product_attributes']);
            //$product->create_product_thumnail($id);
        }
        return $id;
    }

    /**
     * Подготовка данных к вставке
     * @param $data
     * @return array
     */
    public function get_prepared_data($data)
    {
        $fills = [
            'products' => array_merge(array('id'), $this->fillable),
            'photos' => [
                'images'
            ],
            'galleries' => [
                'images'
            ],
            'product_attributes' => [
                'attribute_id',
                'attribute_value_id'
            ],
            'product_categories' => [
                'category_id'
            ]
        ];

        foreach (['rating'] as $key) {
            while (($i = array_search($key, $fills['products'])) !== false) {
                unset($fills['products'][$i]);
            }
        }

        $result_data = [];
        foreach ($fills as $table => $table_fills) {
//            if(!isset($result_data[$table]))
//                $result_data[$table] = [];

            if($table == 'product_categories'){
                if (!isset($data[$table]) && isset($data['categories']))
                    $result_data['categories'] = $data['categories'];
                else {
                    foreach ($data[$table] as $category) {
                        $result_data['categories'][] = $category['category_id'];
                    }
                }
            }elseif($table == 'photos'){
                if (is_array($data[$table]) && isset($data[$table][0]) && !is_array($data[$table][0]))
                    $result_data[$table] = $data[$table];
                elseif(is_array($data[$table])) {
                    foreach ($data[$table] as $id => $image) {
                        if (empty($result_data['products']['image_id'])) {
                            $result_data['products']['image_id'] = $image['images'];
                            if (count($data[$table]) > 4) {
                                continue;
                            }
                        }
                        $result_data[$table][] = $image['images'];
                    }
                }
            }elseif($table == 'galleries'){
                if (is_array($data[$table]) && isset($data[$table][0]) && !is_array($data[$table][0]))
                    $result_data[$table] = $data[$table];
                elseif(is_array($data[$table])) {
                    foreach ($data[$table] as $id => $image) {
                        if (empty($result_data['products']['image_id'])) {
                            $result_data['products']['image_id'] = $image['images'];
                            if (count($data[$table]) > 4) {
                                continue;
                            }
                        }
                        $result_data[$table][] = $image['images'];
                    }
                }
            }else{
                if ($table != 'product_attributes') {
                    foreach ($table_fills as $fill) {
                        $result_data[$table][$fill] = isset($data[$table][$fill]) ? $data[$table][$fill] : ($fill == 'stock' ? 1 : null);
                    }
                } else {
                    if (isset($data['product_attributes'])) {
                        foreach ($data['product_attributes'] as $attribute) {
                            if (!empty($attribute['attribute_value_id']))
                                $result_data[$table][] = $attribute;
                        }
                    }
                }
            }
        }

        if(empty($result_data['products']['meta_title']))
            $result_data['products']['meta_title'] = $result_data['products']['name'];

        if(!empty($result_data['products']['old_price'])){
            $result_data['products']['old_price'] = (float)$result_data['products']['old_price'];
        }

        if(empty($result_data['products']['price']) && !empty($result_data['products']['old_price']))
            $result_data['products']['price'] = $result_data['products']['old_price'];
        else{
            $result_data['products']['price'] = (float)$result_data['products']['price'];
        }

        if($result_data['products']['price'] >= $result_data['products']['old_price']){
            $result_data['products']['old_price'] = 0;
        }

        return $result_data;
    }

    /**
     * Проверка существования продукта с таким url_alias
     * @param $url_alias
     * @return bool
     */
    public function isset_product_with_url_alias($url_alias)
    {
        return (bool)$this->where('url_alias', $url_alias)
            ->take(1)
            ->count();
    }

    /**
     * Генерация алиаса
     * @param $product
     * @return string
     */
    public function generate_alias($product){
        $url_alias = str_replace(['(', ')', '"', ' ', '/', '\\'], ['', '', '', '_', '_', '_'], mb_strtolower($this->rus2lat($product['name']))) . '_' . rand(1, 100);

        return $url_alias;
    }

    /**
     * Транслит
     * @param $string
     * @return mixed
     */
    public function rus2lat($string)
    {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => "",    'ы' => 'y',   'ъ' => "",
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => "",    'Ы' => 'Y',   'Ъ' => "",
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        );
        return strtr($string, $converter);
    }

    /**
     * Значения атрибута товара
     *
     * @param $name
     * @return array
     */
    public function get_attribute($name){
        $attr_val = new AttributeValues;
        $attributes = $attr_val->select('attribute_values.name', 'attribute_values.value')
            ->join('product_attributes', 'product_attributes.attribute_value_id', '=', 'attribute_values.id')
            ->join('attributes', 'attributes.id', '=', 'attribute_values.attribute_id')
            ->where('attributes.name', $name)
            ->where('product_attributes.product_id', $this->id)
            ->get()
            ->toArray();

        return $attributes;
    }

    /**
     * Получение вариаций (атрибутов с дополнительной стоимостью)
     *
     * @return array
     */
    public function get_variations(){
        $variations = [];
        $attributes = $this->get_attributes->groupBy('attribute_id');

        foreach ($attributes as $attribute => $values){
            foreach ($values as $value){
                if($value->price > 0){
//                    $variations[$attribute] = $values->sortBy('price')->values();
                    $variations[$attribute] = $values->sortBy(
                        function ($value, $key) {
                            return $value->price*100000 + $value->id;
                        }
                    )->values();
                    continue;
                }
            }
        }

        return $variations;
    }

    /**
     * Связанные товары
     *
     * @return array
     */
//    public function related(){
//        $categories = $this->categories->last();
//        if(!empty($categories)){
//            $products = $categories->products()->where('stock', 1)->with('image')->inRandomOrder()->limit(12)->get();
//        }else{
//            $products = [];
//        }
//
//        return $products;
//    }
}