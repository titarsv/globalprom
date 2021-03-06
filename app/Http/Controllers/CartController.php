<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cart;
use App\Models\Products;
use App\Models\ProductsCart;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use App\Models\User;
use App\Models\Order;
use Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    /**
     * Обновление продукта в корзине
     *
     * @param Request $request
     * @param Cart $cart
     * @return mixed
     */
    public function updateCart(Request $request, Cart $cart)
    {
        $product_id = $request->product_id;

        $current_cart = $cart->current_cart();

        if(empty($request->variation)){
            $variation = 0;
        }else{
//            $variations = array_diff($request->variations, array(''));
            $variation = $request->variation;
        }

        if($request->action == 'add'){
            $product_quantity = $request->quantity ? $request->quantity : 1;
            $current_cart->increment_product_quantity($product_id, $product_quantity, $variation);
        }elseif($request->action == 'remove'){
            $current_cart->remove_product($product_id, $variation);
        }elseif($request->action == 'update'){
            $product_quantity = $request->quantity ? $request->quantity : 0;
            $current_cart->update_product_quantity($product_id, $product_quantity, $variation);
        }

        return $this->getCart($request);
    }

	/**
	 * Корзина пользователя
	 *
	 * @param Request $request
	 *
	 * @return $this|array
	 */
    public function getCart(Request $request)
    {
        $cart = new Cart;
        $current_cart = $cart->current_cart();

//        if(isset($request->type) && $request->type == 'order_cart'){
            return [
            	'data' => [
            		'total_qty' => $current_cart->total_quantity,
            		'total_price' => $current_cart->total_price,
		            'products' => $current_cart->get_products()
	            ],
	            'html' => [
	            	'order_cart' => view('public.layouts.order_cart')->with('cart', $current_cart)->render(),
		            'popup_cart' => view('public.layouts.cart')->with('cart', $current_cart)->render(),
		            'minicart' => view('public.layouts.minicart')->render()
	            ]
            ];
//        }else{
//            return view('public.layouts.cart')->with('cart', $current_cart);
//        }
    }

    /**
     * Страница оформления заказа
     *
     * @param Cart $cart
     * @return mixed
     */
    public function show(Cart $cart)
    {
        $products = $cart->get_products();
        $current_cart = $cart->current_cart();
        $user = null;
        
        if(Sentinel::check()){
            $user = User::find(Sentinel::check()->id);
        }

        return view('public.order')
            ->with('user', $user)
            ->with('products', $products)
            ->with('cart', $current_cart)
            ->with('delivery_price', 0);
    }

    /**
     * @param Request $request
     * @return array|bool
     */
    public function update(Request $request)
    {
        $user_cart_id = Session::get('user_id');

        $current_cart = Cart::where('user_id', $user_cart_id)->first();

        if(is_null($current_cart)){
            return false;
        }
        $current_cart->products_cart()->delete();
        if(!empty($request['cart'])){
            foreach($request['cart'] as $product){
                if($product['product_quantity'] <= 0){
                    continue;
                }
                $new_products_cart = new ProductsCart($product);
                $current_cart->products_cart()->save($new_products_cart);
            }
        }

        $products_in_cart = $current_cart->products_cart()->get();
        $products_quantity = $products_in_cart->sum('product_quantity');
        $products_array = $products_in_cart->lists('product_quantity' , 'product_id')->toArray();

        $products_sum = 0;
        foreach($products_in_cart as $products){
            $products_sum += $products->product->price * $products_array[$products->product->id];
        }

        $current_cart->update(['products_quantity' => $products_quantity, 'products_sum' => $products_sum]);
//        $current_cart->update(['products_quantity' => $request['products_quantity']]);
        return ['products_quantity' => $request['products_quantity'], 'sum' => $request['sum']];
    }

    /**
     * @param $user_cart_id
     * @return mixed
     */
    public function getCartProducts($user_cart_id)
    {
        $cart = Cart::where('user_id',$user_cart_id)->first();

        return $cart;
    }

    /**
     * Метод передает корзину юзеру
     * @param $user_id
     * @return array
     */
    public static function cartToUser($user_id)
    {
        $user_cart_id = Session::get('user_id');
        $current_cart_from_sess = Cart::where('user_id', $user_cart_id)->first();
        $current_cart = [];
        if(!is_null($current_cart_from_sess)) {
            $current_cart_from_sess->update(['user_id' => $user_id]);
            $current_cart = $current_cart_from_sess;
        }
        $current_cart_from_user = Cart::where('user_id', $user_id)->first();
        if(!is_null($current_cart_from_user)) {
//            $current_cart_from_user->update(['user_id' => $user_id]);
            $current_cart = $current_cart_from_user;
            $user_cart_id = $current_cart->user_cart_id;
            Session::put('user_id', $user_cart_id);
        }

        return $current_cart;
    }

	/**
	 * Рассылка уведомлений о неоконченной покупке
	 *
	 * @param Cart $cart
	 */
    public function send_reminders(Cart $cart){
	    $reminders = $cart->get_reminders();

	    foreach ($reminders as $reminder){
		    $user = $reminder->user;

		    if(!empty($user->email)){
			    Mail::send('emails.cart_reminder', ['user' => $user, 'products' => $reminder->get_products()], function($msg) use ($user){
				    $msg->from('info@globalprom.com.ua', 'Интернет-магазин Globalprom');
				    $msg->to($user->email);
				    $msg->subject('Неоконченный заказ на сайте Globalprom');
			    });

			    $reminder->reminder_success();
		    }else{
			    $reminder->reminder_success();
		    }
	    }
    }

    public function hide_reminder(Cart $cart){
	    $current_cart = $cart->current_cart();

	    $user_data = json_decode($current_cart->user_data, true);
	    if(!is_array($user_data)){
		    $user_data = ['statuses' => []];
	    }

	    $user_data['statuses'][] = 'reminder_showed';

	    $current_cart->update(['user_data' => json_encode($user_data)]);
    }
}
