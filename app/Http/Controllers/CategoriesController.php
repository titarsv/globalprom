<?php

namespace App\Http\Controllers;

use App\Models\Attributes;
use App\Models\ModuleBestsellers;
use App\Models\Modules;
use App\ProductAttributes;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Settings;
use App\Models\Image;
use App\Models\Products;
use App\Http\Requests;
use Validator;
use Cartalyst\Sentinel\Native\Facades\Sentinel;


class CategoriesController extends Controller
{

    private $rules = [
        'name' => 'required',
//        'meta_title' => 'required|max:75',
//        'meta_description' => 'max:180',
//        'meta_keywords' => 'max:180',
        'url_alias' => 'required|unique:categories',
    ];

    private $messages = [
        'name.required' => 'Поле должно быть заполнено!',
        'meta_title.required' => 'Поле должно быть заполнено!',
//        'meta_title.max' => 'Максимальная длина заголовка не может превышать 75 символов!',
//        'meta_description.max' => 'Максимальная длина описания не может превышать 180 символов!',
//        'meta_keywords.max' => 'Максимальная длина ключевых слов не может превышать 180 символов!',
        'url_alias.required' => 'Поле должно быть заполнено!',
        'url_alias.unique' => 'Значение должно быть уникальным для каждой категории!'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.categories.index')->with('categories', Categories::paginate(20));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create')
            ->with('categories', Categories::all())
            ->with('attributes', Attributes::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Categories $categories)
    {

        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->with('message-error', 'Сохранение не удалось! Проверьте форму на ошибки!')
                ->withErrors($validator);
        }

        $categories->fill($request->except('_token'));
        $categories->description = !empty($request->description) ? $request->description : null;
        $categories->sort_order = !empty($request->sort_order) ? $request->sort_order : 0;
        $categories->save();

        return redirect('/admin/categories')
            ->with('message-success', 'Категория ' . $categories->name . ' успешно добавлена.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Categories::find($id);
        $attributes = [];
        if(!empty($category->attributes)) {
            foreach ($category->attributes as $attribute){
                $attributes[] = $attribute->id;
            }
        }

        return view('admin.categories.edit')
            ->with('attributes', Attributes::all())
            ->with('related_attributes', $attributes)
            ->with('category', $category)
            ->with('categories', Categories::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Categories $categories)
    {

        $rules = $this->rules;
        $rules['url_alias'] = 'required|unique:categories,url_alias,'.$id;

        $validator = Validator::make($request->all(), $rules, $this->messages);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->with('message-error', 'Сохранение не удалось! Проверьте форму на ошибки!')
                ->withErrors($validator);
        }

        $category = $categories->find($id);
        $category->fill($request->except('_token'));
        $category->description = !empty($request->description) ? $request->description : null;
        $category->sort_order = !empty($request->sort_order) ? $request->sort_order : 0;
        $category->save();

        $category->attributes()->sync($request->related_attribute_ids);

        return redirect('/admin/categories')
            ->with('message-success', 'Категория ' . $category->name . ' успешно обновлена.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Categories::find($id);
        $category->delete();

        return redirect('/admin/categories')
            ->with('message-success', 'Категория ' . $category->name . ' успешно удалена.');
    }

    /**
     * Страница категории
     *
     * @param $request
     * @param null $alias
     * @param string $filters
     * @return mixed
     */
    public function show(Request $request, $alias = null, $filters = '')
    {
        $categories = new Categories;

        if($request->page == 1){
            $except = ['page'];
            if($request->sort == 'name-asc')
                $except[] = 'sort';
            if($request->limit == 12)
                $except[] = 'limit';

            $r = $request->except($except);

            if(empty($r)){
	            return redirect()->to('/categories/'.$alias);
            }else{
	            return redirect()->action(
		            'CategoriesController@show', ['request' => $r, 'alias' => $alias, 'filters' => $filters], 301
	            );
            }
        }

        $sort_array = [
            [
                'value' => 'price-asc',
                'name'  => 'возрастанию цены'
            ],
            [
                'value' => 'price-desc',
                'name'  => 'убыванию цены'
            ],
            [
                'value' => 'name-asc',
                'name'  => 'названию'
            ],
            [
                'value' => 'rating-asc',
                'name'  => 'популярности'
            ],
            [
                'value' => 'updated_at-desc',
                'name'  => 'новизне'
            ]
        ];

        if(empty($request->limit)){
            $take = 12;
        }else{
            $take = $request->limit;
        }

        $filter = $this->getFilter($filters);

        $current_sort = $request->sort ? explode('-', $request->sort) : ['price', 'asc'];
		if(count($current_sort) == 1)
            $current_sort[1] = 'ASC';

        if($alias == null || is_array($alias))
            $category = null;
        else
            $category = $categories->where('url_alias', $alias)->where('status', 1)->first();

        if($category === null)
            abort(404);

        $category_id = $category->id;
        $min_price = $categories->min_price($category_id);
        $max_price = $categories->max_price($category_id);

        $subcategory_id = null;

        $price = [];
        $price[0] = empty($request->price_min) ? 0: $request->price_min;
        $price[1] = empty($request->price_max) || $request->price_max > $max_price ? $max_price: $request->price_max;

        $products = $categories->get_products($category_id, $subcategory_id, $filter, $current_sort, $take, $price);

        $product_attributes = [];
        $product_attributes_values = [];

        foreach ($products as $product) {
            foreach ($product->attributes as $attribute) {
                $product_attributes[] = $attribute->attribute_id;
                $product_attributes_values[] = $attribute->attribute_value_id;
            }
        }

        $product_attributes_values = array_unique($product_attributes_values);

        $product_attributes = $categories->find($category_id)->attributes;

        if(method_exists($products, 'total')) {
//            $paginator = $products->appends(['sort' => $current_sort[0].'-'.$current_sort[1], 'limit' => $take, 'price' => $request->price]);
            $paginator = $products->appends($request->except(['page']));
        } else {
            $paginator = false;
        }

//        $viewed = json_decode($request->cookie('viewed'), true);
//
//        if(!is_array($viewed))
//            $viewed = [];

//        $viewed_products = $prod::whereIn('id', $viewed)->get();

        $available_categories = [];
        $available = [];
        foreach ($available_categories as $cat){
            $available[] = $cat->id;
        }

        return view('public.category')
            ->with('category', $category)
            ->with('products', $products)
            ->with('attributes', $product_attributes)
            ->with('sort_array', $sort_array)
            ->with('current_sort', $current_sort[0].'-'.$current_sort[1])
            ->with('product_attributes_values', $product_attributes_values)
            ->with('filter', $filter)
            ->with('price', array_merge([$min_price, $max_price], $price))
            ->with('paginator', $paginator)
//            ->with('viewed_products', $viewed_products)
//            ->with('selected_categories', isset($_GET['categories'])?$_GET['categories']:[])
            ->with('available_categories', $available)
//            ->with('root_categories', $categories->get_root_categories())
            ->with('limit', $take)
            ->with('category_id', $category_id);
    }

    protected function getFilter($filters){
        $filter = [];

        if (isset($_GET['filter_attributes']) && $_GET['filter_attributes'] !== null) {
            foreach ($_GET['filter_attributes'] as $attribute_id => $value) {
                foreach ($value['value'] as $attribute_value_id => $on) {
                    $filter[$attribute_id][] = $attribute_value_id;
                }
            }
        }elseif(!empty($filters)){
            $filter = $this->prepared_filters($filters);
        }

        return $filter;
    }

    /**
     * Парсинг фильтров
     *
     * @param string $string
     * @return array
     */
    protected function prepared_filters($string = ''){
        $data = explode('_', $string);

        $filters = [];
        foreach ($data as $filter){
            $filter_data = explode('-', $filter);
            if(count($filter_data) >= 2) {
                $key = $filter_data[0];
                array_splice($filter_data, 0, 1);
                $filters[$key] = $filter_data;
            }
        }

        return $filters;
    }
}
