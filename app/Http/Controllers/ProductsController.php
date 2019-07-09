<?php

namespace App\Http\Controllers;

use App\Models\Attributes;
use App\Models\AttributeValues;
use App\Models\Manufacturers;
use App\Models\Variation;
use App\Product;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Object_;
use Validator;

use App\Http\Requests;
use App\Models\Categories;
use App\Models\Settings;
use App\Models\Products;
use App\Models\Image;
use App\Models\Modules;
use App\Models\ModuleRecommended;
use Excel;
use App\Models\Gallery;
use App\Http\Controllers\ImagesController;

class ProductsController extends Controller
{

    private $products;
    private $rules = [
        //'name' => 'required|unique:products',
        'price' => 'required|numeric',
        //'articul' => 'required|unique:products',
        'quantity' => 'numeric',
//        'capacity' => 'numeric',
//        'product_category_id' => 'required',
//        'meta_title' => 'required|max:75',
//        'meta_description' => 'max:180',
//        'meta_keywords' => 'max:180',
        //'url_alias' => 'required|unique:products|unique:categories',
    ];

    private $messages = [
        'name.required' => 'Поле должно быть заполнено!',
        'name.unique' => 'Название товара должно быть уникальным!',
        'price.required' => 'Поле должно быть заполнено!',
        'price.numeric' => 'Значение должно быть числовым!',
        'articul.required' => 'Поле должно быть заполнено!',
        'articul.unique' => 'Артикул товара должен быть уникальным!',
        'quantity.numeric' => 'Значение должно быть числовым!',
        'capacity.numeric' => 'Значение должно быть числовым!',
        'product_category_id.not_in' => 'Не выбрана категория товара!',
        'meta_title.required' => 'Поле должно быть заполнено!',
//        'meta_title.max' => 'Максимальная длина заголовка не может превышать 75 символов!',
//        'meta_description.max' => 'Максимальная длина описания не может превышать 180 символов!',
//        'meta_keywords.max' => 'Максимальная длина ключевых слов не может превышать 180 символов!',
        'url_alias.required' => 'Поле должно быть заполнено!',
        'url_alias.unique' => 'Значение должно быть уникальным для каждого товара!',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Categories $categories, Manufacturers $manufacturers)
    {

        $category_id = false;
        $stock = false;

        if (isset($request->category)) {
            $category_id = $request->category;
        }
        if (isset($request->stock)) {
            $stock = $request->stock;
        }

        $products = Products::select('products.*')->when($category_id, function($query) use ($category_id){
                //return $query->where('product_category_id', $category_id);
                return $query->join('product_categories', 'products.id', '=', 'product_categories.product_id')->where('product_categories.category_id', $category_id);
            })
            ->when(($stock !== false), function($query) use ($stock){
                return $query->where('stock', $stock);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(1000);
			
		if(!empty($category_id)){
            $products->appends(['category' => $category_id]);
        }

        return view('admin.products.index')
            ->with('products', $products)
            ->with('categories', $categories->all())
            ->with('manufacturers', $manufacturers->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Products();

        return view('admin.products.create')
            ->with('categories', Categories::all())
            ->with('labels', $product->labels())
            ->with('attributes', Attributes::all());
    }

    /**
     * Создание товара
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Image $image, Products $products, Gallery $gallery)
    {
        $attributes_error = $this->validate_attributes($request->product_attributes);

        $validator = Validator::make($request->all(), $this->rules, $this->messages);

//        dd($image->find($request->image_id)->href);
//
//        $image_href = $image->find($request->image_id)->href;
//
//        $request->merge(['href' => $image_href]);

        if ($validator->fails() || $attributes_error) {
            return redirect()
                ->back()
                ->withInput()
                ->with('message-error', 'Сохранение не удалось! Проверьте форму на ошибки!')
                ->withErrors($validator)
                ->with('attributes_error', $attributes_error);
        }

//        $gallery_id = $gallery->add_gallery($request->gallery);
//
//        $request->merge(['gallery_id' => $gallery_id]);

        $data = ['products' => $request->except('product_category_id')];
        if (!empty($request->product_attributes)) {
            $data['product_attributes'] = [];
            foreach ($request->product_attributes as $attribute) {
                $data['product_attributes'][] = [
                    'attribute_id' => $attribute['id'],
                    'attribute_value_id' => $attribute['value'],
                    'price' => $attribute['price']
                ];
            }
        }

        if(!empty($request->product_category_id)){
            $data['categories'] = $request->product_category_id;
        }

        $data['galleries'] = $request->gallery;
        $data['photos'] = $request->photos;

        $id = $products->insert_product($data);

        if($id != 'already_exist'){
            $this->updateVariations($products->find($id), $request->variations);
        }

        return redirect('/admin/products')
            ->with('message-success', 'Товар ' . $products->name . ' успешно добавлен.');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Products::find($id);

        if(empty($product))
            abort(404);

        $categories = [];
        if(!empty($product->categories)) {
            foreach ($product->categories as $category){
                $categories[] = $category->id;
            }
        }

        $sets = Products::where('id', '<>', $id)->where('stock', 1)->get();
        $added_set = $product->set_products()->orderBy('product_sets.id')->get()->pluck('id')->toArray();

        return view('admin.products.edit')
            ->with('product', $product)
            ->with('related', $product->related()->orderBy('related_products.id')->get()->pluck('id')->toArray())
            ->with('similar', $product->similar()->orderBy('similar_products.id')->get()->pluck('id')->toArray())
            ->with('categories', Categories::all())
            ->with('added_categories', $categories)
            ->with('sets', $sets)
            ->with('added_set', $added_set)
            ->with('labels', $product->labels())
            ->with('attributes', Attributes::all());
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Image $image)
    {
        $rules = $this->rules;
        $rules['url_alias'] = 'required|unique:categories|unique:products,url_alias,'.$id;

        $attributes_error = $this->validate_attributes($request->product_attributes);

        $validator = Validator::make($request->all(), $rules, $this->messages);

        if ($validator->fails() || $attributes_error) {
            return redirect()
                ->back()
                ->withInput()
                ->with('message-error', 'Сохранение не удалось! Проверьте форму на ошибки!')
                ->withErrors($validator)
                ->with('attributes_error', $attributes_error);
        }

        $product_table_fill = $request->only([
            'name',
            'excerpt',
            'description',
            'options',
            'sizes',
            'image_id',
            'price',
            'old_price',
            'articul',
            'stock',
            'action',
            'label',
            'video',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'robots',
            'url_alias',
            'product_related_category_id'
        ]);

        $product = Products::find($id);

        $gallery = [];
        if(!empty($request->gallery)){
            foreach($request->gallery as $i => $id){
                $gallery[] = [
                    'id' => $id,
                    'alt' => isset($request->gallery_img_alt[$i]) ? $request->gallery_img_alt[$i] : '',
                    'title' => isset($request->gallery_img_title[$i]) ? $request->gallery_img_title[$i] : ''
                ];
            }
        }

        if(is_null($product->gallery)){
            $gallery = new Gallery();
            $product_table_fill['gallery_id'] = $gallery->add_gallery($gallery);
        }else{
            $product->gallery->images = json_encode($gallery);
        }

        $photos = [];
        if(!empty($request->photos)){
            foreach($request->photos as $i => $id){
                $photos[] = [
                    'id' => $id,
                    'alt' => isset($request->photos_img_alt[$i]) ? $request->photos_img_alt[$i] : '',
                    'title' => isset($request->photos_img_title[$i]) ? $request->photos_img_title[$i] : ''
                ];
            }
        }

        if(is_null($product->photos)){
            $gallery = new Gallery();
            $product_table_fill['photos_id'] = $gallery->add_gallery($photos);
        }else{
            $product->photos->images = json_encode($photos);
        }

//        $product->set_products()->sync($request->sets);
//        $product->related()->sync($request->related);
//        $product->similar()->sync($request->similar);

        $product->set_products()->sync([]);
        if(!empty($request->sets)){
            foreach ($request->sets as $id){
                $product->set_products()->attach([$id]);
            }
        }
        $product->related()->sync([]);
        if(!empty($request->related)){
            foreach ($request->related as $id){
                $product->related()->attach([$id]);
            }
        }
        $product->similar()->sync([]);
        if(!empty($request->similar)){
            foreach ($request->similar as $id){
                $product->similar()->attach([$id]);
            }
        }

        $product->fill($product_table_fill);

        $product->push();


        $product->categories()->sync($request->product_category_id);

        if (!empty($request->product_attributes)) {
            foreach ($request->product_attributes as $attribute) {
                $product_attributes[] = [
                    'product_id' => $product->id,
                    'attribute_id' => $attribute['id'],
                    'attribute_value_id' => $attribute['value'],
//                    'price' => $attribute['price']
                ];
            }

            $product->attributes()->delete();
            $product->attributes()->createMany($product_attributes);
            $product->create_product_thumnail($product->id);
        }else{
            $product->attributes()->delete();
        }

        $this->updateVariations($product, $request->variations);

        return redirect('/admin/products/edit/'.$product->id)
            ->with('message-success', 'Товар ' . $product->name . ' успешно отредактирован.');
    }

    /**
     * Обновление вариаций
     *
     * @param $product
     * @param $variations
     */
    public function updateVariations($product, $variations){
        $current_variations = $product->variations;
        $add = [];
        $remove = $current_variations->pluck(['id'])->toArray();
        if(!empty($variations)){
            foreach ($variations as $variation){
                $add_var = true;
                foreach ($current_variations as $var){
                    if(empty($variation['id'])){
                        $add_var = false;
                        break;
                    }
                    if(isset($variation['price']) && $var->price == $variation['price']){
                        if(empty(array_diff($variation['id'], $var->attribute_values->pluck(['id'])->toArray())) && empty(array_diff($var->attribute_values->pluck(['id'])->toArray(), $variation['id']))){
                            $add_var = false;
                            unset($remove[array_search($var->id,$remove)]);
                            break;
                        }
//                    dd(collect($variation['id'])->sort()->values()->all());
//                    dd($var->attribute_values->pluck(['id'])->sort()->values()->all());
                    }
                }
                if($add_var){
                    $add[] = $variation;
                }
            }
        }

        //foreach ($product->variations as $variation){
            //$variation->attribute_values()->detach();
            //$variation->delete();
            //$variation->update(['product_id' => 0]);
        //}

        foreach ($remove as $id){
            $v = new Variation();
            $v->find($id)->update(['product_id' => 0]);
        }
        foreach ($add as $variation){
            if(!empty($variation['price']) && !empty($variation['id'])){
                $v = new Variation();
                $id = $v->insertGetId(['product_id' => $product->id, 'price' => $variation['price']]);
                $v->find($id)->attribute_values()->attach($variation['id']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Products::find($id);
        $product->delete();

        return redirect()->back()
            ->with('message-success', 'Товар ' . $product->name . ' успешно удален.');
    }

    /**
     * Получение списка всех атрибутов
     *
     * @param Attributes $attributes
     * @return string|void
     */
    public function getAttributes(Attributes $attributes)
    {

        $attr = $attributes->all();
        $response = [];

        if(!empty($attr)){
            foreach ($attr as $attribute) {
                $response[] = [
                    'attribute_id'    => $attribute->id,
                    'attribute_name'  => $attribute->name
                ];
            }
        }

        return json_encode($response);

    }

    /**
     * Получение списка значений переданного атрибута
     *
     * @param Attributes $attributes
     * @param Request $request
     * @return string|void
     */
    public function getAttributeValues(Attributes $attributes, Request $request)
    {

        $attribute = $attributes->find((int)$request->attribute_id);
        $response = [];

        if ($attribute !== null) {
            foreach ($attribute->values as $value) {
                $response[] = [
                    'attribute_value_id'    => $value->id,
                    'attribute_value'       => $value->name
                ];
            }
        }

        return json_encode($response);

    }

    /**
     * Живой поиск для модулей
     *
     * @param Request $request
     * @param Products $products
     * @return string|void
     */
    public function livesearch(Request $request, Products $products)
    {
        $search = explode(' ', $request->search);
        $results = $products->where('stock', 1);
        foreach($search as $s){
            $results->where('name', 'like', '%' . $s . '%');
        }
        $results = $results->paginate(5);

        foreach ($results as $result) {

            if ($result) {
                $json[] = [
                    'product_id' => $result->id,
                    'name'       => $result->name,
                    'url'        => $result->url_alias,
                    'price'        => $result->price,
                    'image'        => $result->image->url(),
                ];
            }
        }

        if (!empty($json)) {
            return json_encode($json);
        } else {
            return json_encode([['empty' => 'Ничего не найдено!']]);
        }
    }

    /**
     * @param $alias
     * @return mixed
     */
    public function show($alias, Request $request)
    {
        $product = Products::where('url_alias', $alias)->where('stock', 1)->with(['variations', 'variations.attribute_values', 'variations.attribute_values.attribute'])->first();

        if(empty($product)){
            abort(404);
        }

        setlocale(LC_TIME, 'RU');
        $reviews = $product->reviews()
            ->where('published', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        $product_reviews = [];
        foreach ($reviews as $review) {
            $review->date = iconv("cp1251", "UTF-8", $review->updated_at->formatLocalized('%d.%m.%Y'));
            if(!is_null($review->parent_review_id)){
                $product_reviews[$review->parent_review_id]['comments'][] = $review;
            } else {
                $product_reviews[$review->id]['parent'] = $review;
            }
        }

        // Если у товара нет галлереи возвращаем его изображение
        if(empty($product->gallery))
            $gallery = [['image' => $product->image, 'alt' => $product->name, 'title' => $product->name]];
        else
            $gallery = $product->gallery->objects();

        array_splice($gallery, 4);

        $attributes = [];

        foreach ($product->attributes as $attribute){
            if (!isset($attributes[$attribute->info->name])) {
                $attributes[$attribute->info->name] = [];
            }
            $attributes[$attribute->info->name][] = ['name' => $attribute->value->name, 'value' => $attribute->value->value];
        }

        $max_price = $product->price;
        $variations_attrs = [];
        $variations_prices = [];

        foreach($product->variations as $variation){
            $values = $variation->attribute_values;
            $variations_prices[implode('_', $values->pluck(['id'])->sort()->values()->all())] = [
                'price' => $variation->price,
                'id' => $variation->id
            ];
            if($max_price < $variation->price){
                $max_price = $variation->price;
            }
            foreach($values as $value){
                $attr = $value->attribute;
                if(!isset($variations_attrs[$attr->id])){
                    $variations_attrs[$attr->id] = [
                        'name' => $attr->name,
                        'values' => [
                            $value->id => $value->name
                        ]
                    ];
                }elseif(!isset($variations_attrs[$attr->id]['values'][$value->id])){
                    $variations_attrs[$attr->id]['values'][$value->id] = $value->name;
                }
            }
            asort($variations_attrs[$attr->id]['values']);
        }

        return response(view('public.product')
            ->with('product', $product)
            ->with('max_price', $max_price)
            ->with('gallery', $gallery)
            ->with('reviews', $product_reviews)
            ->with('product_attributes', $attributes)
            ->with('related', $product->related()->where('stock', 1)->orderBy('related_products.id')->with('image')->get())
            ->with('similar', $product->similar()->where('stock', 1)->orderBy('similar_products.id')->with('image')->get())
            ->with('variations_prices', $variations_prices)
            ->with('variations', $variations_attrs));
    }

    /**
     * Галлерея товара
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function gallery($id, $active, Request $request)
    {
        $product = Products::where('id', $id)->where('stock', 1)->first();

        if(empty($product)){
            abort(404);
        }

        // Если у товара нет галлереи возвращаем его изображение
        if(empty($product->gallery))
            $gallery = [['image' => $product->image, 'alt' => $product->name, 'title' => $product->name]];
        else
            $gallery = $product->gallery->objects();

        array_splice($gallery, 4);

        return response(view('public.layouts.view_popup_prod')
            ->with('product', $product)
            ->with('active', $active)
            ->with('gallery', $gallery));
    }

    /**
     * Размеры товара
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function sizes($id, Request $request){
        $product = Products::where('id', $id)->where('stock', 1)->first();

        return response(view('public.layouts.sizes')
            ->with('product', $product));
    }

    /**
     * Похожие товары
     *
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function related($id){
        $product = Products::where('id', $id)->where('stock', 1)->first();

        return response(view('public.layouts.related')
            ->with('related', $product->similar()->where('stock', 1)->orderBy('similar_products.id')->with('image')->get()));
    }

    /**
     * Страница поиска
     *
     * @param Products $products
     * @param Request $request
     * @return mixed
     */
    public function search(Products $products, Request $request)
    {
        $search_text = $request->input('text');

        $id = $request->get('page', 1);

        $data = $products->search($search_text, $id, 8);
        
        if(method_exists($data, 'total')) {
            $paginator = $data->appends(['text' => $search_text]);
        } else {
            $paginator = false;
        }
        
        return view('public.search')->with('products', $data)
            ->with('paginator', $paginator)
            ->with('search_text', $search_text);
    }

    /**
     * Валидация атрибутов товара на одинаковые значения
     *
     * @param $attributes
     * @return bool|string
     */
    public function validate_attributes($attributes) {
        $attributes_error = false;

        if (!empty($attributes)) {
            foreach ($attributes as $product_attribute) {
                $product_attribute_values[] = $product_attribute['value'];
            }

            foreach (array_count_values($product_attribute_values) as $count_value) {
                if ($count_value > 1) {
                    $attributes_error = 'Значения атрибутов не могут быть одинаковы!';
                    break;
                }
            }
        }

        return $attributes_error;
    }

    /**
     * Импорт товаров
     *
     * @param Request $request
     * @param Products $products
     * @param Variation $variations
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function upload(Request $request, Products $products, Variation $variations)
    {
        $update = $request->input('update');
        $errors = false;

        if($request->hasFile('import_file')){
            $errors = [];
            $path = $request->file('import_file')->getRealPath();

            $data = Excel::load($path, function($reader) {

            })->get();

            if($request->update){
                if (!empty($data) && $data->count()) {
                    foreach ($data as $row) {
                        if(!empty($row->Variation_ID)) {
                            $variations->where('id', (int)$row->Variation_ID)->update(['price' => (float)$row->Price]);
                        }elseif(!empty($row->ID)){
                            $products->where('id', (int)$row->ID)->update(['price' => (float)$row->Price, 'old_price' => (float)$row->Old_Price, 'stock' => (int)$row->Stock]);
                        }
                    }
                }
            }else {
                if (!empty($data) && $data->count()) {
                    $prepared_data = [];

                    foreach ($data as $row) {

                        $row_data = ['tables' => []];
                        foreach ($row as $key => $val) {
                            $field = ['options' => $this->get_field_options($key)];

                            // Если данные для этой таблицы ещё не заполнялись
                            if (!isset($row_data['tables'][$field['options']['table']]))
                                $row_data['tables'][$field['options']['table']] = [];

                            // Если поле содержит несколько значений
                            if (isset($field['options']['selector'])) {
                                $vals = explode($field['options']['selector'], $val);

                                // Обходим каждое значение отдельно
                                foreach ($vals as $result) {
                                    $new_row = [];

                                    // Доподнительное поле
                                    if (isset($field['options']['relations'])) {
                                        $relation = preg_replace('/^([^{]+)\{([^}]+)\}/u', '$2', $result);
                                        if ($relation != $result) {
                                            $new_row = array_merge($new_row, [$field['options']['relations'] => preg_replace('/^([^{]+)\{([^}]+)\}/u', '$2', $result)]);
                                            $result = trim(preg_replace('/^([^{]+)\{([^}]+)\}/u', '$1', $result));
                                        }
                                    }

                                    // Делаем необходимые подмены
                                    if (isset($field['options']['replace']) && !empty($result)) {
                                        $result = $this->replace_inserted_data($result, $field['options']['replace']['table'], $field['options']['replace']['find'], $field['options']['replace']['replaced']);
                                    }

                                    // Подгружаем файлы
                                    if (isset($field['options']['load']) && !empty($result)) {
                                        $url = "http://globalprom.com.ua/image/$result";
                                        $table = $field['options']['load'][0];
                                        $replaced = $field['options']['load'][1];
                                        if ($table == 'images') {
                                            $file = new ImagesController(new Image());
                                        }
                                        if (isset($file)) {
                                            $file = $file->uploadFromUrlImages($url);
                                            if ($file) {
                                                $result = $file->$replaced;
                                            } else {
                                                $result = 1;
                                            }
                                        }
                                    }

                                    $new_row = array_merge($new_row, [$field['options']['field'] => $result]);
                                    // Заполняем связанное поле
                                    if (isset($field['options']['attached_fields'])) {
                                        $new_row = array_merge($new_row, $field['options']['attached_fields']);
                                    }

                                    // Добавляем данные в общий поток
                                    if ($result !== '')
                                        $row_data['tables'][$field['options']['table']][] = $new_row;
                                }
                            } else {
                                if (isset($field['options']['replace']) && !empty($val)) {
                                    $val = $this->replace_inserted_data($val, $field['options']['replace']['table'], $field['options']['replace']['find'], $field['options']['replace']['replaced']);
                                }

                                // Подгружаем файлы
                                if (isset($field['options']['load']) && !empty($val)) {
                                    $url = "http://globalprom.com.ua/image/$val";
                                    $table = $field['options']['load'][0];
                                    $replaced = $field['options']['load'][1];
                                    if ($table == 'images') {
                                        $file = new ImagesController(new Image());
                                    }
                                    if (isset($file)) {
                                        $file = $file->uploadFromUrlImages($url);
                                        if ($file) {
                                            $val = $file->$replaced;
                                        } else {
                                            $val = 1;
                                        }
                                    }
                                }

                                if (isset($field['options']['unique'])) {
                                    $row_data['tables'][$field['options']['table']][$field['options']['field']] = $val;
                                } else {
                                    $row_data['tables'][$field['options']['table']][] = [$field['options']['field'] => $val];
                                }
                            }
                        }
                        $prepared_data[] = $row_data;
                    }

                    $errors = $this->validate_prepared_data($prepared_data);

                    if (empty($errors)) {
                        foreach ($prepared_data as $product) {
                            if ($update)
                                $products->update_product($product['tables']);
                            else
                                $products->insert_product($product['tables']);

                            if (isset($product['errors']))
                                $errors[] = $product;
                        }
                    } else {
                        return view('admin.products.upload')
                            ->with('errors', $errors);
                    }
                }
            }
        }

        return view('admin.products.upload')
            ->with('errors', $errors);
    }

    /**
     * Валидация импортируемых данных
     *
     * @param $prepared_data
     * @return array
     */
    public function validate_prepared_data($prepared_data){
        $products = new Products();
        $names = [];
        foreach ($products->select('name')->get() as $product){
            $names[] = $product->name;
        }
        $errors = [];
        foreach ($prepared_data as $id => $row){

            $err = [];

            if(empty($row['tables']['products']['name'])){
                $err[] = 'Не заполнено название товара.';
            }
//            if(in_array($row['tables']['products']['name'], $names)){
//                $err[] = 'Дубль названия товара.';
//            }
//            if(empty($row['tables']['products']['price'])){
//                $err[] = 'Не заполнена цена товара.';
//            }

            foreach ($row['tables']['galleries'] as $image){
                if(empty($image['images'])){
                    $err[] = 'Неизвестное изображение.';
                }
            }

//            foreach ($row['tables']['product_categories'] as $category){
//                if(empty($category['category_id'])){
//                    $err[] = 'Неизвестная категория.';
//                }
//            }

            if(isset($row['tables']['product_attributes'])){
                foreach ($row['tables']['product_attributes'] as $attribute){
                    if(empty($attribute['attribute_value_id'])){
                        $err[] = 'Неизвестное значение атрибута (id атрибута '.$attribute['attribute_id'].').';
                    }
                }
            }

            if(!empty($err)){
                $errors[] = [
                    'id' => $id+1,
                    'errors' => $err
                ];
            }
        }

        return $errors;
    }

    /**
     * Парсинг опций вставки
     *
     * @param $field
     * @return array|bool
     */
    public function get_field_options($field){
        $params = explode('.', $field);
        if(count($params) < 2)
            return false;
        $options = [
            'table' => $params[0],
            'field' => $params[1]
        ];
        $count = count($params);
        if($count > 2){
            for($i=2; $i<$count; $i++){
                if(strpos($params[$i], 'selector') === 0){
                    $options['selector'] = preg_replace('/selector\((.+)\)/', '$1', $params[$i]);
                }elseif(strpos($params[$i], 'attached_field') === 0){
                    if(!isset($options['attached_fields']))
                        $options['attached_fields'] = [];
                    $attached_field = explode(':', preg_replace('/attached_field\((.+)\)/', '$1', $params[$i]), 2);
                    $options['attached_fields'][$attached_field[0]] = $attached_field[1];
                }elseif($params[$i] == 'unique'){
                    $options['unique'] = true;
                }elseif(strpos($params[$i], 'replace') === 0){
                    if(!isset($options['attached_fields']))
                        $options['attached_fields'] = [];
                    $replace = explode(':', preg_replace('/replace\((.+)\)/', '$1', $params[$i]), 3);
                    $options['replace'] = ['table' => $replace[0], 'find' => $replace[1], 'replaced' => $replace[2]];
                }elseif(strpos($params[$i], 'relations') === 0){
                    $options['relations'] = preg_replace('/relations\((.+)\)/', '$1', $params[$i]);
                }elseif(strpos($params[$i], 'load') === 0){
                    $options['load'] = explode(':', preg_replace('/load\((.+)\)/', '$1', $params[$i]), 2);
                }
            }
        }

        return $options;
    }

    /**
     * Получение одного поля таблицы по другому
     *
     * @param $data
     * @param $table
     * @param $find
     * @param $replaced
     * @return mixed
     */
    public function replace_inserted_data($data, $table, $find, $replaced){
        $model_name = 'App\Models\\'.str_replace(' ', '', ucwords(str_replace('_', ' ', preg_replace('/s$/', '', $table))));
        if(!class_exists($model_name))
            $model_name = 'App\Models\\'.str_replace(' ', '', ucwords(str_replace('_', ' ', $table)));
        if(!class_exists($model_name) || $data == '')
            return null;

        $table = new $model_name;
        $result = $table->select($replaced)->where($find, '=', trim($data))->take(1)->get()->first();

        return $result !== null ? $result->$replaced : $result;
    }

    /**
     * Удаление нежелательных символов
     *
     * @param $value
     */
    function trim_value(&$value)
    {
        if(is_string($value)) {
            $value = preg_replace('/(^"|"$|;$|\.$|,$|,\s?,)/', '', preg_replace('@^\s*|\s*$@u', '', $value));
        }
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
            'ь' => "",  'ы' => 'y',   'ъ' => "",
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
            'Ь' => "",  'Ы' => 'Y',   'Ъ' => "",
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        );
        return strtr($string, $converter);
    }

    /**
     * Фид
     *
     * @param Products $products
     */
    public function export(Products $products){
        $data = [];
        foreach($products->where('stock', 1)->where('price', '>', 0)->with(['categories', 'image'])->get() as $product){
            $data[] = [
                'ID' => $product->id,
                'Item title' => $product->name,
                'Category title' => !empty($product->categories) ? $product->categories->first()->name : '',
                'Final URL' => env('APP_URL').'/product/'.$product->url_alias,
                'Image URL' => empty($product->image) ? env('APP_URL').'/uploads/no_image.jpg' : env('APP_URL').$product->image->url(),
                'Price' => (!empty($product->old_price) && $product->price < $product->old_price) ? $product->old_price.' UAH' : $product->price.' UAH',
                'Sale Price' => (!empty($product->old_price) && $product->price < $product->old_price) ? $product->price.' UAH' : ''
            ];
        }

        Excel::create('remarketing', function($excel) use ($data) {

            // Set the title
            $excel->setTitle('Remarketing');

            // Chain the setters
            $excel->setCreator('Triplefork')
                ->setCompany('Triplefork');

            // Call them separately
            $excel->setDescription('Remarketing');

            $excel->sheet('First sheet', function($sheet) use ($data) {
                $sheet->fromArray($data);
            });

        })->download('csv');
    }

    /**
     * Фид для прома
     *
     * @param Products $products
     * @return mixed
     */
    public function prom_export(Products $products){
        $data = [];
        foreach($products->where('stock', 1)->where('price', '>', 0)->with(['categories', 'image'])->get() as $product){
            $data[] = [
                'ID' => $product->id,
                'Title' => $product->name,
                'Description' => empty($product->description) ? $product->name : strip_tags($product->description),
                'Link' => env('APP_URL').'/product/'.$product->url_alias,
                'Image_​link' => empty($product->image) ? env('APP_URL').'/uploads/no_image.jpg' : env('APP_URL').$product->image->url(),
                'Stock' => $product->stock,
                'Price' => (!empty($product->old_price) && $product->price < $product->old_price) ? $product->old_price.' UAH' : $product->price.' UAH',
                'Brand' => 'GlobalProm',
                'Condition' => 'Новое'
            ];
        }

        $contents = view('public.rss_feed')
            ->with('products', $data);

        return response($contents)
            ->header('Content-Type', 'text/xml');

//        Excel::create('prom', function($excel) use ($data) {
//
//            // Set the title
//            $excel->setTitle('Prom');
//
//            // Chain the setters
//            $excel->setCreator('Triplefork')
//                ->setCompany('Triplefork');
//
//            // Call them separately
//            $excel->setDescription('Prom');
//
//            $excel->sheet('First sheet', function($sheet) use ($data) {
//                $sheet->fromArray($data);
//            });
//
//        })->download('csv');
    }

    public function price_export(Products $products){
        $data = [];
        foreach($products->whereNull('deleted_at')->with(['variations.attribute_values'])->get() as $product){
            $data[] = [
                'ID' => $product->id,
                'Variation_ID' =>0,
                'Name' => $product->name,
                'Price' => $product->price,
                'Old_Price' => $product->old_price,
                'Stock' => $product->stock,
                'URL' => env('APP_URL').'/product/'.$product->url_alias,
            ];
            foreach ($product->variations as $variation){
                $attributes = [];
                if($variation->attribute_values->count()){
                    foreach($variation->attribute_values as $val){
                        $attributes[] = $val->attribute->name . ': ' . $val->name;
                    }
                }
                $data[] = [
                    'ID' => $product->id,
                    'Variation_ID' => $variation->id,
                    'Name' => implode(', ', $attributes),
                    'Price' => $variation->price,
                    'Sale Price' => '',
                    'Stock' => $product->stock,
                    'URL' => env('APP_URL').'/product/'.$product->url_alias,
                ];
            }
        }
//        dd($data);

        Excel::create('prices', function($excel) use ($data) {

            // Set the title
            $excel->setTitle('Prices');

            // Chain the setters
            $excel->setCreator('Triplefork')
                ->setCompany('Triplefork');

            // Call them separately
            $excel->setDescription('Prices');

            $excel->sheet('First sheet', function($sheet) use ($data) {
                $sheet->fromArray($data);
            });

        })->download('xls');
    }

    /**
     * Фид для FB
     *
     * @param Products $products
     * @return mixed
     */
    public function fb_feed(Products $products){
        $data = [];
        foreach($products->where('stock', 1)->where('price', '>', 0)->with(['categories', 'image'])->get() as $product){
            $data[] = [
                'id' => $product->id,
                'title' => $product->name,
                'description' => empty($product->description) ? $product->name : strip_tags($product->description),
                'availability' => 'in stock',
                'condition' => 'new',
                'price' => (!empty($product->old_price) && $product->price < $product->old_price) ? $product->old_price.' UAH' : $product->price.' UAH',
                'link' => env('APP_URL').'/product/'.$product->url_alias,
                'image_​link' => empty($product->image) ? env('APP_URL').'/uploads/no_image.jpg' : env('APP_URL').$product->image->url(),
                'brand' => 'GlobalProm'
            ];
        }

        Excel::create('feed', function($excel) use ($data) {

            // Set the title
            $excel->setTitle('Feed');

            // Chain the setters
            $excel->setCreator('Triplefork')
                ->setCompany('Triplefork');

            // Call them separately
            $excel->setDescription('Feed');

            $excel->sheet('First sheet', function($sheet) use ($data) {
                $sheet->fromArray($data);
            });

        })->download('csv');
    }
}
