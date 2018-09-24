@if(!is_null($cart))
    <div class="order-popup-inner" id="cart_content">
        <div class="order-popup__title-wrapper">
            <strong class="order-popup__title">В корзине: </strong>
            <span class="order-popup__count-items">{{ $cart->total_quantity or '0' }} {{ Lang::choice('товар|товара|товаров', $cart->total_quantity, [], 'ru') }}</span>
        </div>
        <ul class="order-popup__list">
            @foreach ($cart->get_products() as $code => $product)
                @if(is_object($product['product']))
                    <li class="order-popup__item">
                        <div class="order-popup__pic-wrapper">
                            <img class="order-popup__pic" src="{{ is_null($product['product']->image) ? '/assets/images/no_image.jpg' : $product['product']->image->url('cart') }}" alt="">
                        </div>
                        <a href="{{env('APP_URL')}}/product/{{ $product['product']->url_alias }}" class="order-popup__title-item">
                            {{ $product['product']->name }}
                            @if(!empty($product['variations']))
                                (
                                @foreach($product['variations'] as $name => $val)
                                    {{ $name }}: {{ $val }};
                                @endforeach
                                )
                            @endif
                        </a>
                        <div class="order-popup__count-wrapper">
                            <div class="order-popup__minus cart_minus">–</div>
                            <input class="order-popup__count-field count_field" type="text" pattern="^[ 0-9]+$" value="{{ $product['quantity'] }}" size="5" data-prod-id="{{ $code }}">
                            <div class="order-popup__plus cart_plus">+</div>
                        </div>
                        <span class="order-popup__price" data-one-price="{{ round($product['price'], 2) }}">{{ number_format( round($product['price'], 2), 0, ',', ' ' ) }} грн.</span>
                        <i class="order-popup__del mc_item_delete" data-prod-id="{{ $code }}"></i>
                    </li>

                    {{--@php--}}
                        {{--$related = $product['product']->related()->where('stock', 1)->get();--}}
                    {{--@endphp--}}
                    {{--@if($related->count())--}}
                    {{--<li class="order-popup__item related">--}}
                        {{--<div class="section-title"><span>С этим товаром покупают</span></div>--}}
                        {{--@foreach($related as $related_product)--}}
                            {{--<div>--}}
                                {{--@if(!empty($product->action))--}}
                                    {{--<span class="item-label">Акция <i>%</i></span>--}}
                                {{--@endif--}}
                                {{--<div class="order-popup__pic-wrapper">--}}
                                    {{--<img class="order-popup__pic" src="{{ is_null($related_product->image) ? '/assets/images/no_image.jpg' : $related_product->image->url('cart') }}" alt="">--}}
                                {{--</div>--}}
                                {{--<a href="{{env('APP_URL')}}/product/{{ $related_product->url_alias }}" class="order-popup__title-item">--}}
                                    {{--{{ $related_product->name }}--}}
                                {{--</a>--}}
                                {{--<div class="item-info__wrapper">--}}
                                    {{--@if(!empty($related_product->old_price))--}}
                                        {{--<div class="item-price-old">{{ round($related_product->old_price, 2) }} грн</div>--}}
                                    {{--@else--}}
                                        {{--<div class="item-price-old" style="text-decoration: none;">&nbsp;</div>--}}
                                    {{--@endif--}}
                                    {{--<div class="item-price">{{ round($related_product->price, 2) }} грн</div>--}}
                                    {{--<a class="item-btn" href="/product/{{ $related_product->url_alias }}">Подробнее</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--@endforeach--}}
                    {{--</li>--}}
                    {{--@endif--}}

                @endif
            @endforeach
        </ul>
        <div class="order-popup__totals">
            <span class="order-popup__totals-title">Общая стоимость: </span>
            <strong class="order-popup__sum">{{ $cart->total_price ? number_format( round($cart->total_price, 2), 0, ',', ' ' ) : '0' }} грн.</strong>
        </div>
        <div class="order-popup__buttons">
            <a class="order-popup__back" href="">Вернуться в каталог</a>
            <a href="{{env('APP_URL')}}/cart" class="order-popup__buy">Оформить заказ</a>
        </div>
    </div>
@else
    <div class="order-popup__empty">
        Здесь пусто...
    </div>
@endif
<button title="Close (Esc)" type="button" class="mfp-close">×</button>