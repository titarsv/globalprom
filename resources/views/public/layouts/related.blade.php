<div class="actions-slider">
    @foreach($related as $related_product)
        <div class="item col-sm-4">
            <div class="item-inner action">
                @if(!empty($related_product->action))
                    <span class="item-label">Акция <i>%</i></span>
                @endif
                <div class="item-pic__wrapper">
                    <a href="{{env('APP_URL')}}/product/{{ $related_product->url_alias }}">
                        {!! $related_product->image->webp_image('product_list', ['class' => 'item-pic', 'alt' => $related_product->name]) !!}
                    </a>
                </div>
                <div class="item-info__wrapper">
                    <a class="item-link" href="{{env('APP_URL')}}/product/{{ $related_product->url_alias }}">{{ $related_product->name }}</a>
                    @if(!empty($related_product->old_price))
                        <div class="item-price-old">{{ round($related_product->old_price, 2) }} грн</div>
                    @else
                        <div class="item-price-old" style="text-decoration: none;">&nbsp;</div>
                    @endif
                    <div class="item-price">{{ round($related_product->price, 2) }} грн</div>
                    <div class="more">
                        <a class="item-btn" href="/product/{{ $product->url_alias }}">Подробнее</a>
                        <button class="add_to_cart_btn" data-id="{{ $product->id }}">Cart</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>