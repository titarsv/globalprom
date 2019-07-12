<span class="cart-items-before"></span>
@if(!empty($cart->total_price))
    <div class="cart-items__inner">
        <ul class="cart-items__list">
            @foreach ($cart->get_products() as $code => $product)
                @if(is_object($product['product']))
                    <li class="cart-item">
                        <div class="cart-item__pic-wrapper">
                            <img class="cart-item__pic" src="{{ is_null($product['product']->image) ? '/assets/images/no_image.jpg' : $product['product']->image->url('cart') }}" alt="{{ $product['product']->name }}">
                        </div>
                        <a href="{{env('APP_URL')}}/product/{{ $product['product']->url_alias }}" class="cart-item__title">
                            {{ $product['product']->name }}
                            @if(!empty($product['variations']))
                                (
                                @foreach($product['variations'] as $name => $val)
                                    {{ $name }}: {{ $val }};
                                @endforeach
                                )
                            @endif
                        </a>
                        <div class="cart-item__count-wrapper">
                            <span class="cart-item__counter">x{{ $product['quantity'] }}</span>
                        </div>
                        <span class="cart-item__price">{{ number_format( round($product['price'], 2), 0, ',', ' ' ) }} грн.</span>
                        <span class="cart-item__del mc_item_delete" data-prod-id="{{ $code }}"></span>
                    </li>
                @endif
            @endforeach
        </ul>
        <div class="cart-items__footer">
            <a href="{{env('APP_URL')}}/cart" class="cart-items__btn">Оформить заказ</a>
        </div>
    </div>
@else
    <div class="cart-items__empty">Здесь пусто</div>
@endif