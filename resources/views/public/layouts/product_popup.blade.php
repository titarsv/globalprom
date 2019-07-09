<div class="product-main__wrapper">
    <div class="col-xs-12 product-title__wrapper">
        <h1 class="product-title" itemprop="name" style="text-align: left;">{{ $product->name }}</h1>
    </div>
    <div class="product-slider__wrapper">
		<?php $labels = $product->labels(); ?>
        @if(!empty($product->label) && $product->label != 'z' && isset($labels[$product->label]))
            <div class="card__img">
                <img src="/images/labels/{{ $product->label }}.png" alt="{{ $product->name }}">
            </div>
        @else
            <div class="card__img" style="visibility: hidden;"></div>
        @endif
        <div class="product-slider">
            @forelse($gallery as $i => $image)
                @if(is_object($image['image']))
                    <div class="product-slide popup-btn" data-index="{{ $i }}" data-mfp-src="/product_gallery/{{ $product->id }}/{{ $i }}" data-type="ajax">
                        {!! $image['image']->webp_image('product', ['alt' => empty($image['alt']) ? '' : $image['alt'], 'title' => empty($image['title']) ? '' : $image['title'], 'itemprop' => 'image']) !!}
                    </div>
                @endif
            @empty
                <div class="product-slide popup-btn" data-index="0" data-mfp-src="#view_popup_prod">
                    <img src="/assets/images/no_image.jpg" alt="{{ $product->name }}">
                </div>
            @endforelse
            @if(!empty($product->video))
                <div class="product-slide popup-btn" data-index="{{ isset($i) ? ($i + 1) : 0 }}" data-mfp-src="#view_popup_prod">
                    <div class="iframe-wrapper">
                        <iframe src="{{ $product->video }}" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
                    </div>
                </div>
            @endif
        </div>
        <div class="product-nav">
            @forelse($gallery as $image)
                @if(is_object($image['image']))
                    <div class="nav-slide">
                        {!! $image['image']->webp_image('product', ['alt' => empty($image['alt']) ? '' : $image['alt'], 'title' => empty($image['title']) ? '' : $image['title'], 'itemprop' => 'image']) !!}
                    </div>
                @endif
            @empty
                <div class="nav-slide">
                    <img src="/assets/images/no_image.jpg">
                </div>
            @endforelse
            @if(!empty($product->video))
                <div class="nav-slide" style="border: none;">
                    <div class="nav-slide-video">
                        <img class="nav-slide-video__pic" src="/images/youtube.png" alt="{{ $product->name }}">
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="product-info__wrapper">
        @if(count($variations))
            <form action="#" id="variations">
                <input type="hidden" id="variation" name="variation" value="">
                @foreach($variations as $attr_id => $attr)
                    <div class="product-filter__wrapper">
                        <span class="product-filter__title">{{ $attr['name'] }}:</span>
                        <div class="product-filter__select-wrapper">
                            <select name="attr[{{ $attr_id }}]" class="product-filter__select variation-select">
                                <option value="">Сделайте выбор</option>
                                @php natsort($attr['values']); @endphp
                                @foreach($attr['values'] as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endforeach
                @foreach($variations_prices as $variation => $val)
                    <input class="hidden" type="radio" id="var_{{ $variation }}" name="variation" value="{{ $val['id'] }}" data-price="{{ $val['price'] }}">
                @endforeach
            </form>
        @endif
        <div class="product-price__wrapper">
            <div class="product-price__inner">
                <span class="product-price__title">Цена:</span>
                <meta itemprop="priceCurrency" content="грн." />
                <meta itemprop="price" content="{{ round($product->price, 2) }}" />
                @if(!empty($product->price))
                    <div class="product-price" data-price="{{ round($product->price, 2) . ($max_price > $product->price ? ' - '.$max_price : '') }}"><span>{{ round($product->price, 2) . ($max_price > $product->price ? ' - '.$max_price : '') }}</span> грн.</div>
                @else
                    <div class="product-price" data-price="{{ round($product->price, 2) . ($max_price > $product->price ? ' - '.$max_price : '') }}"><span>Цена по запросу</span></div>
                @endif
            </div>
            <small style="color: #7a7a7a; font-size: 80%">* Цена может меняться в зависимости от выбранных параметров<br>** Цены действуют только на территории Украины</small>
        </div>
        @if($product->stock)
            <table class="result-price">
                <tr>
                    <td>
                        <div class="product-filter__title">
                            Количество:
                        </div>
                    </td>
                    <td>
                        <div class="order-popup__count-wrapper">
                            <div class="order-popup__minus cart_minus">–</div>
                            <input class="order-popup__count-field count_field" pattern="^[ 0-9]+$" value="1" size="5" type="text">
                            <div class="order-popup__plus cart_plus">+</div>
                        </div>
                    </td>
                </tr>
                <tr class="result-product-price-wrapper">
                    <td>
                        <div class="product-filter__title">
                            Сумма заказа:
                        </div>
                    </td>
                    <td>
                        <div class="result-product-price">
                            {{ round($product->price, 2) . ($max_price > $product->price ? ' - '.$max_price : '') }} грн.
                        </div>
                    </td>
                </tr>
            </table>
            <div class="product-order__wrapper">
                <button class="product-order__btn btn_buy" data-prod-id="{{ $product->id}}">Заказать</button>
                <button class="product-calc__btn popup-btn" data-mfp-src="#quick-order-popup">Купить в один клик</button>
            </div>
        @endif
    </div>
</div>