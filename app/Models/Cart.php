<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use App\Models\Variation;
use Carbon\Carbon;
use Cookie;

class Cart extends Model
{
    protected $table = 'cart';
    protected $fillable = [
        'user_id',
        'user_ip',
        'session_id',
        'products',
        'total_quantity',
        'total_price',
        'user_data',
        'cart_data',
	    'created_at',
	    'updated_at'
    ];

	public function user()
	{
		return $this->hasOne('App\Models\User', 'id', 'user_id');
	}

    /**
     * Получение корзины пользователя
     *
     * @param bool $create - Создавать новую корзину или нет
     * @return mixed
     */
    public function current_cart($create = true){
	    $cart_id = Cookie::get('cart_id');
	    $user = Sentinel::check();

        if($user) {
            $user_id = $user->id;
            $cart = $this->where('user_id', $user_id)->first();

            if(!empty($cart_id) && !empty($cart) && $cart->id != $cart_id){
	            $saved_cart = $this->where('id', $cart_id)->where('total_quantity', '>', 0)->first();
	            if(!empty($saved_cart->total_quantity)){
		            $products = json_decode($cart->products, true) + json_decode($saved_cart->products, true);
		            $cart->products = json_encode($products);
		            $cart->total_quantity += $saved_cart->total_quantity;
		            $cart->total_price += $saved_cart->total_price;
		            $cart->updated_at = date('Y-m-d H:i:s');
		            if($cart->session_id != Session::getId()){
			            $cart->session_id = Session::getId();
		            }
		            $cart->save();
	            }
            }

            if(!is_null($cart) && $cart->session_id != Session::getId())
                $cart->update(['session_id' => Session::getId(), 'updated_at' => date('Y-m-d H:i:s')]);
        } else {
	        $user_id = 0;
	        if(!empty($cart_id)) {
		        $cart = $this->where('id', $cart_id)->where('user_id', 0)->first();
	        }else{
		        $cart = $this->where('session_id', Session::getId())->first();
	        }
        }

        if(is_null($cart) && $create) {
            $cart = $this->create_cart($user_id);
        }

	    Cookie::queue('cart_id', $cart->id, 2628000, null, null, false, false);

        return $cart;
    }

    /**
     * Создание новой корзины
     *
     * @param $user_id
     * @return mixed
     */
    public function create_cart($user_id){

        $id = $this->insertGetId([
            'user_id' => $user_id,
            'session_id' => Session::getId(),
            'products' => null,
            'total_quantity' => 0,
            'total_price' => 0,
	        'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return $this->where('id', $id)->first();
    }

    /**
     * Обновление корзины
     */
    public function update_cart(){
        $products = json_decode($this->products, true);

        $total_quantity = 0;
        $total_price = 0;

        foreach ($products as $product_id => $data) {
            $total_quantity += $data['quantity'];
            $total_price += (float)$data['price'] * (int)$data['quantity'];
        }

        $this->update(['total_quantity' => $total_quantity, 'total_price' => $total_price, 'updated_at' => date('Y-m-d H:i:s')]);

    }

    /**
     * Получение продуктов из корзины
     *
     * @return array
     */
    public function get_products()
    {
        $current_cart = $this->current_cart();
        $products_in_cart = json_decode($current_cart->products, true);
        $products = [];

        if(!is_null($products_in_cart)) {
            foreach ($products_in_cart as $product_id => $data) {
                $variation_attrs = [];
                if(!empty($data['variation'])){
                    $v = new Variation();
                    $variation = $v->find($data['variation']);
                    $values = $variation->attribute_values;
                    foreach($values as $value){
                        $attr = $value->attribute;
                        if(!isset($variation_attrs[$attr->name])){
                            $variation_attrs[$attr->name] = $value->name;
                        }
                    }
                }

                $ids = explode('_', $product_id);
                $products[$product_id] = [
                    'product'   => Products::where('id', $ids[0])->with('attributes.value')->first(),
                    'quantity'  => $data['quantity'],
                    'variations'  => $variation_attrs,
                    'price'  => $data['price']
                ];
            }
        }
        
        return $products;
    }

    /**
     * Код товара
     *
     * @param $product_id
     * @param $variation
     * @return string
     */
    private function get_product_code($product_id, $variation){
        if(!empty($variation)){
//            foreach ($variations as $key => $val){
//                $product_id .= '_'.$key.'-'.$val;
//            }
            $product_id .= '_'.$variation;
        }
        return $product_id;
    }

    /**
     * Добавление товара в корзину
     *
     * @param $product_id
     * @param int $quantity
     * @param $variation
     */
    public function add_product($product_id, $quantity = 1, $variation){
        $product_code = $this->get_product_code($product_id, $variation);

        $products = json_decode($this->products, true);
        if(is_null($products))
            $products = [];

        if(array_key_exists($product_code, $products)){
            $products[$product_code] = ['quantity' => $products[$product_id] + $quantity];
        } else {
            $products[$product_code] = ['quantity' => $quantity];
            if(!empty($variation)){
                $products[$product_code]['variation'] = $variation;
            }
            $products[$product_code]['price'] = $this->get_product_price($product_id, $variation);
        }

        $this->update(['products' => json_encode($products), 'updated_at' => date('Y-m-d H:i:s')]);
        $this->update_cart();
    }

    /**
     * Удаление товара из корзины
     *
     * @param $product_code
     */
    public function remove_product($product_code){
        $products = json_decode($this->products, true);
        unset($products[$product_code]);

        $this->update(['products' => json_encode($products), 'updated_at' => date('Y-m-d H:i:s')]);
        $this->update_cart();
    }

    /**
     * Изменение колличества товара в корзине на указанную величину
     *
     * @param $product_id
     * @param $delta
     * @param $variation
     */
    public function increment_product_quantity($product_id, $delta, $variation = 0){
        $product_code = $this->get_product_code($product_id, $variation);

        if ($this->product_isset($product_code)) {

            $products = json_decode($this->products, true);
            $products[$product_code]['quantity'] = $products[$product_code]['quantity'] + $delta;
            $this->products = json_encode($products);
            $this->update_cart();

        } elseif ($delta > 0) {
            $this->add_product($product_id, $delta, $variation);
        }
    }

    /**
     * Изменение колличества товара в корзине
     *
     * @param $product_id
     * @param $quantity
     * @param array $variations
     */
    public function update_product_quantity($product_id, $quantity, $variations = []){
        $product_code = $this->get_product_code($product_id, $variations);

        if ($quantity <= 0) {
            $this->remove_product($product_code);
        }

        if ($this->product_isset($product_code)) {
            $products = json_decode($this->products, true);
            $products[$product_code]['quantity'] = $quantity;
            $this->update(['products' => json_encode($products), 'updated_at' => date('Y-m-d H:i:s')]);
            $this->update_cart();
        } else {
            $this->add_product($product_id, $quantity, $variations);
        }
    }

    /**
     * Проверка наличия товара в корзине
     *
     * @param $product_code
     * @return bool
     */
    public function product_isset($product_code){
        $products = json_decode($this->products, true);

        if(is_null($products)) {
            return false;
        } else {
            return array_key_exists($product_code, $products);
        }
    }

    /**
     * Стоимость вариативного товара
     *
     * @param $product_id
     * @param $variation
     * @return mixed
     */
    public function get_product_price($product_id, $variation){
        $product = Products::find($product_id);
        $price = $product->price;

//        if(!empty($variations)){
//            $price += $product->attributes()->whereIn('attribute_value_id', array_values($variations))->where('price', '>', 0)->get()->sum('price');
//        }

        $variation = $product->variations()->where('id', $variation)->first();
        if(!empty($variation)){
            $price = $variation->price;
        }

        return $price;
    }

	/**
	 * Получение претендентов на рассылку уведомлений о неоконченной покупке
	 *
	 * @return mixed
	 */
    public function get_reminders(){
	    $this->where('total_quantity', 0)->where(function ($query) {
		    $query->where('updated_at', '<', Carbon::now()->subDays(3))
		          ->orWhere('updated_at', null);
	    })->delete();
		$reminders = $this->where('user_id', '>', 0)->where('total_quantity', '>', 0)->where('updated_at', '<', Carbon::now()->subDays(3))->where(function ($query) {
			$query->where('user_data', 'NOT LIKE', '%reminder_send%')
			      ->orWhere('user_data', null);
		})->limit(15)->get();

		return $reminders;
    }

	/**
	 * Сохранене статуса отправки уведомления о неоконченной покупке
	 */
    public function reminder_success(){
    	$user_data = json_decode($this->user_data, true);
    	if(!is_array($user_data)){
		    $user_data = ['statuses' => []];
	    }

	    if(($key = array_search('reminder_showed', $user_data)) !== FALSE){
		    unset($user_data[$key]);
	    }

	    $user_data['statuses'][] = 'reminder_send';

    	$this->update(['user_data' => json_encode($user_data)]);
    }
}