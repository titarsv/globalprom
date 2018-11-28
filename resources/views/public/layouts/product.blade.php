<div class="item cat-item col-sm-4 col-xs-6">
    <div class="item-inner">
        <div class="item-pic__wrapper">
            <?php $labels = $product->labels(); ?>
            @if(!empty($product->label) && $product->label != 'z' && isset($labels[$product->label]))
                <div class="card__img">
                    <img src="/images/labels/{{ $product->label }}.png" alt="{{ $product->name }}">
                </div>
            @else
                <div class="card__img" style="visibility: hidden;"></div>
            @endif
            <a href="{{env('APP_URL')}}/product/{{ $product->url_alias }}">
                {!! $product->image->webp_image('product_list', ['alt' => $product->name]) !!}
                {{--<img class="item-pic" src="{{ $product->image == null ? '/assets/images/no_image.jpg' : $product->image->url('product_list') }}" alt="">--}}
            </a>
        </div>
        <div class="item-info__wrapper">
            <a class="item-link" href="{{env('APP_URL')}}/product/{{ $product->url_alias }}">{{ $product->name }}</a>
            @if(!empty($product->old_price))
                <div class="item-price-old">{{ round($product->old_price, 2) }} грн</div>
            @else
                <div class="item-price-old" style="text-decoration: none;">&nbsp;</div>
            @endif
            @if(!empty($product->price))
                <div class="item-price">{{ round($product->price, 2) }} грн</div>
            @else
                <div class="item-price">Цена по запросу</div>
            @endif
            <a class="item-btn" href="/product/{{ $product->url_alias }}">Подробнее</a>
        </div>
    </div>
</div>
