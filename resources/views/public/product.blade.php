@extends('public.layouts.main')
@section('meta')
    <title>
        @if(empty(trim($product->meta_title)) || $product->meta_title == 'NULL')
            В продаже {!! $product->name !!} по доступной цене
        @else
            {{ $product->meta_title }}
        @endif
    </title>

    @if(empty(trim($product->meta_description)) || $product->meta_description == 'NULL')
        <meta name="description" content="На нашем сайте всегда в наличии {!! $product->name !!}} по лучшей цене. Доставка товара осуществляется во все города Украины быстро и недорого.">
    @else
        <meta name="description" content="{!! $product->meta_description !!}">
    @endif

    <meta name="keywords" content="{!! $product->meta_keywords !!}">
    @if(!empty($product->robots))
        <meta name="robots" content="{!! $product->robots !!}">
    @endif

    <meta name="canonical" content="{{env('APP_URL')}}/product/{!! $product->url_alias !!}">
@endsection

@section('breadcrumbs')
    {!! Breadcrumbs::render('product', $product, $product->categories) !!}
@endsection

@section('content')
    <main class="main-wrapper">
        <section class="product-wrapper" itemscope itemtype="http://schema.org/Product">
            <div class="container">
                <div class="col-xs-12 product-title__wrapper">
                    <h1 class="product-title" itemprop="name" style="text-align: left;">{{ $product->name }}</h1>
                    @if(!empty($reviews))
                        @php
                            $bestRating = 0;
                            $sumRating = 0;
                            $reviewCount = 0;
                            foreach($reviews as $review){
                                if($review['parent']->grade > $bestRating){
                                    $bestRating = $review['parent']->grade;
                                }
                                $sumRating += $review['parent']->grade;
                                $reviewCount++;
                            }
                        @endphp
                        @if($reviewCount > 0)
                            <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating" class="hidden">
                                <span itemprop="ratingValue">{{ round($sumRating/$reviewCount, 2) }}</span>
                                <span itemprop="bestRating">{{ $bestRating }}</span>
                                <span itemprop="reviewCount">{{ $reviewCount }}</span>
                            </div>
                        @endif
                    @endif
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12">
                    <div class="product-main__wrapper">
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
                                        <div class="product-slide popup-btn" data-index="{{ $i }}" data-mfp-src="#view_popup_prod">
                                            <img src="{{ $image['image']->url('full') }}"{!! empty($image['alt']) ? '' : ' alt="'.$image['alt'].'"' !!}{!! empty($image['title']) ? '' : ' title="'.$image['title'].'"' !!} itemprop="image">
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
                                            <img class="nav-pic" src="{{ $image['image']->url('full') }}"{!! empty($image['alt']) ? '' : ' alt="'.$image['alt'].'"' !!}{!! empty($image['title']) ? '' : ' title="'.$image['title'].'"' !!}>
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
                                        {{--<span class="nav-slide-video__txt">Bидеообзор</span>--}}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="product-info__wrapper" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                            @if($product->stock)
                            <div class="availibility-wrapper">
                                <i class="availibility-icon"></i>
                                <span class="availibility-text" itemprop="availability" href="http://schema.org/InStock">Есть в наличии</span>
                            </div>
                            @endif
                            @if(!empty($product->action))
                            <div class="action-info__wrapper">
                                {!! $product->action !!}
                            </div>
                            @endif
                            <div class="short-descr__wrapper">
                                <span class="short-descr__title">Описание:</span>
                                <p class="short-descr__text">
                                    {!! $product->excerpt !!}
                                </p>
                            </div>
                            {{--@if(count($variations))--}}
                                {{--<form action="#" id="variations">--}}
                                {{--@foreach($variations as $attr => $values)--}}
                                    {{--<div class="product-filter__wrapper">--}}
                                        {{--<span class="product-filter__title">{{ $values->first()->info->name }}:</span>--}}
                                        {{--<div class="product-filter__select-wrapper">--}}
                                            {{--<select name="attr[{{ $attr }}]" class="product-filter__select variation-select">--}}
                                                {{--<option value="" data-price="{{ round($product->price, 2) . ($max_price > $product->price ? ' - '.$max_price : '') }} грн.">--</option>--}}
                                                {{--@foreach($values as $key => $value)--}}
                                                    {{--<option value="{{ $value->value->id }}" data-price="{{ round($product->price + $value->price, 2) }} грн.">{{ $value->value->name }}</option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                            {{--<select name="attr[{{ $attr }}]" class="product-filter__select variation-select">--}}
                                                {{--<option value="" data-price="0">--</option>--}}
                                                {{--@foreach($values as $key => $value)--}}
                                                    {{--<option value="{{ $value->value->id }}" data-price="{{ round($value->price, 2) }}">{{ $value->value->name }}</option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--@endforeach--}}
                                {{--</form>--}}
                            {{--@endif--}}
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
                                <span class="product-price__title">Цена:</span>
                                <meta itemprop="priceCurrency" content="грн." />
                                <meta itemprop="price" content="{{ round($product->price, 2) }}" />
                                @if(!empty($product->price))
                                    <div class="product-price" data-price="{{ round($product->price, 2) . ($max_price > $product->price ? ' - '.$max_price : '') }}"><span>{{ round($product->price, 2) . ($max_price > $product->price ? ' - '.$max_price : '') }}</span> грн.</div>
                                @else
                                    <div class="product-price" data-price="{{ round($product->price, 2) . ($max_price > $product->price ? ' - '.$max_price : '') }}"><span>Цена по запросу</span></div>
                                @endif
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
                        <div class="product-adv__wrapper">
                            <ul class="product-adv__list">
                                @if(in_array('Планетарные', $product->categories->pluck('name')->toArray()) || in_array('Мотор-редукторы 3МП', $product->categories->pluck('name')->toArray()) || in_array('Мотор-редукторы МР', $product->categories->pluck('name')->toArray()) || in_array('Мотор-редукторы МПО', $product->categories->pluck('name')->toArray()))
                                    <li class="product-adv__item">
                                        <i class="product-adv__icon ai1"></i>
                                        <div class="product-adv__title">Гарантия:</div>
                                        <span class="product-adv__text">18 мес.</span>
                                    </li>
                                    <li class="product-adv__item">
                                        <i class="product-adv__icon ai2"></i>
                                        <div class="product-adv__title">Доставка:</div>
                                        <span class="product-adv__text">1-2 раб. дня</span>
                                    </li>
                                    <li class="product-adv__item">
                                        <i class="product-adv__icon ai3"></i>
                                        <div class="product-adv__title">Оплата:</div>
                                        <span class="product-adv__text">По 20% предоплате</span>
                                    </li>
                                @else
                                    <li class="product-adv__item">
                                        <i class="product-adv__icon ai1"></i>
                                        <div class="product-adv__title">Гарантия:</div>
                                        <span class="product-adv__text">12 мес.</span>
                                    </li>
                                    <li class="product-adv__item">
                                        <i class="product-adv__icon ai2"></i>
                                        <div class="product-adv__title">Доставка:</div>
                                        <span class="product-adv__text">1-2 раб. дня</span>
                                    </li>
                                    <li class="product-adv__item">
                                        <i class="product-adv__icon ai3"></i>
                                        <div class="product-adv__title">Оплата:</div>
                                        <span class="product-adv__text">По предоплате</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12">
                    <nav class="product-tabs">
                        <ul class="product-tabs__list">
                            @if(!empty($product->description))
                            <li class="product-tabs__item active"><span>Описание</span></li>
                            @endif
                            @if(!empty($product->options))
                            <li class="product-tabs__item{{ empty($product->description) ? ' active' : '' }}"><span>Опции</span></li>
                            @endif
                            @if(!empty($product->sizes))
                                <li class="product-tabs__item{{ empty($product->description) && empty($product->options) ? ' active' : '' }}"><span>Размеры</span></li>
                            @endif
                            <li class="product-tabs__item"><span>Фотогалерея</span></li>
                            {{--@if(count($variations))--}}
                            {{--<li class="product-tabs__item"><span>Цены</span></li>--}}
                            {{--@endif--}}
                            <li class="product-tabs__item"><span>Отзывы</span></li>
                            {{--<li class="product-tabs__item"><a href="#similar-products"><span>С этим товаром покупают</span></a></li>--}}
                        </ul>
                        @if(!empty($product->description))
                        <div class="product-tabs__content active">
                            <div class="product-description" itemprop="description">
                                {!! $product->description !!}
                            </div>
                        </div>
                        @endif
                        @if(!empty($product->options))
                        <div class="product-tabs__content{{ empty($product->description) ? ' active' : '' }}">
                            <div class="product-specs">
                                <strong>{{ $product->name }}. Ниже приведены технические характеристики товара:</strong>
                                {!! $product->options !!}
                            </div>
                        </div>
                        @endif
                        @if(!empty($product->sizes))
                            <div class="product-tabs__content{{ empty($product->description) && empty($product->options) ? ' active' : '' }}">
                                <div class="product-specs">
                                    {!! $product->sizes !!}
                                </div>
                            </div>
                        @endif
                        <div class="product-tabs__content">
                            <div class="row product-gallery">
                                @if(!is_null($product->photos))
                                    @foreach($product->photos->objects() as $image)
                                        @if(is_object($image['image']))
                                            <a href="{{env('APP_URL')}}{{ $image['image']->url('full') }}" class="col-md-3 col-xs-6 image-popup-vertical-fit">
                                                <div class="product-gallery__item">
                                                    <img class="product-gallery__pic" src="{{ $image['image']->url('full') }}"{!! empty($image['alt']) ? '' : ' alt="'.$image['alt'].'"' !!}{!! empty($image['title']) ? '' : ' title="'.$image['title'].'"' !!}>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        {{--@if(count($variations))--}}
                        {{--<div class="product-tabs__content">--}}
                            {{--<div class="product-prices">--}}
                                {{--@foreach($variations as $attr => $values)--}}
                                    {{--<table>--}}
                                        {{--<tr>--}}
                                            {{--<td>Наименование</td>--}}
                                            {{--<td>{{ $product->name }}</td>--}}
                                        {{--</tr>--}}
                                        {{--@foreach($values as $key => $value)--}}
                                            {{--<tr>--}}
                                                {{--<td>{{ $value->value->name }}</td>--}}
                                                {{--<td>{{ round($product->price + $value->price, 2) }}</td>--}}
                                            {{--</tr>--}}
                                        {{--@endforeach--}}
                                    {{--</table>--}}
                                {{--@endforeach--}}
                                {{--<span class="product-prices__footnote">* Цены указаны в гривне с НДС. Партнерская скидка 15%.</span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--@endif--}}
                        <div class="product-tabs__content">
                            <div class="product-reviews">
                                <div class="product-review__wrapper">
                                    @forelse($reviews as $review)
                                        <div class="product-review">
                                            <span class="product-review__title">
                                                 @if(!empty($review['parent']->user))
                                                    {{ $review['parent']->user->first_name }}
                                                @else
                                                    {{ $review['parent']->author }}
                                                @endif
                                            </span>
                                            <p class="product-review__txt">{!! $review['parent']->review !!}</p>
                                            <small class="product-review__date">{!! $review['parent']->date !!}</small>
                                        </div>
                                        @if(!empty($review['parent']->answer))
                                            <div class="product-answer">
                                                <i></i>
                                                <span class="product-answer__title">Ответ</span>
                                                <div class="product-answer__txt">{!! $review['parent']->answer !!}</div>
                                            </div>
                                        @else

                                        @endif
                                    @empty
                                        <div class="product-review">
                                            <span class="review-item__name">У этого товара пока нет отзывов! Будьте первым!</span>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="product-review__form-wrapper">
                                <span class="product-review__form-title">Написать отзыв - {{ $product->name }}</span>
                                <form action="#" class="product-review__form review-form">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="type" value="review">
                                    <input type="hidden" name="product_id" value="{!! $product->id !!}">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input class="product-review__form-input" type="text" id="review-form__input_name" name="name" value="{!! $user->first_name or '' !!}" placeholder="Имя">
                                        </div>
                                        <div class="col-sm-6">
                                            <input class="product-review__form-input" type="text" id="review-form__input_email" name="email" value="{!! $user->email or '' !!}" placeholder="Email">
                                        </div>
                                    </div>
                                    <textarea class="product-review__form-textarea" placeholder="Ваш отзыв" id="review-form__input_comment" name="review"></textarea>
                                    <span class="product-review__footnote">Примечание: HTML разметка не поддерживается! Используйте обычный текст.</span>
                                    <div class="product-review__rate-wrapper">
                                        <strong class="product-review__rate-title">Оценка:</strong>
                                        <span class="product-review__rate-txt">Плохо</span>
                                        <div class="product-review__rate-checkbox">
                                            <input class="product-review__rate-chck" type="radio" name="grade" id="rating1" value="1">
                                            <label for="rating1"><span></span></label>
                                        </div>
                                        <div class="product-review__rate-checkbox">
                                            <input class="product-review__rate-chck" type="radio" name="grade" id="rating2" value="2">
                                            <label for="rating2"><span></span></label>
                                        </div>
                                        <div class="product-review__rate-checkbox">
                                            <input class="product-review__rate-chck" type="radio" name="grade" id="rating3" value="3">
                                            <label for="rating3"><span></span></label>
                                        </div>
                                        <div class="product-review__rate-checkbox">
                                            <input class="product-review__rate-chck" type="radio" name="grade" id="rating4" value="4">
                                            <label for="rating4"><span></span></label>
                                        </div>
                                        <div class="product-review__rate-checkbox">
                                            <input class="product-review__rate-chck" type="radio" name="grade" id="rating5" value="5">
                                            <label for="rating5"><span></span></label>
                                        </div>
                                        <span class="product-review__rate-txt">Хорошо</span>
                                    </div>
                                    {{--<div class="product-review__capcha-wrapper">--}}
                                        {{--<input class="product-review__form-input capcha-input" type="text" name="name" data-validate-required="Обязательное поле" placeholder="Введите код, указанный на картинке">--}}
                                        {{--<div class="product-review__capcha-block">--}}
                                            {{--<img src="data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAABQAAD/4QMraHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjMtYzAxMSA2Ni4xNDU2NjEsIDIwMTIvMDIvMDYtMTQ6NTY6MjcgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzYgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjJCMURGQzdFMjM4NjExRThCRENDQ0I0M0U4NUYzMDk1IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjJCMURGQzdGMjM4NjExRThCRENDQ0I0M0U4NUYzMDk1Ij4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MkIxREZDN0MyMzg2MTFFOEJEQ0NDQjQzRTg1RjMwOTUiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MkIxREZDN0QyMzg2MTFFOEJEQ0NDQjQzRTg1RjMwOTUiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7/7gAOQWRvYmUAZMAAAAAB/9sAhAACAgICAgICAgICAwICAgMEAwIC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" alt="">--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    <button type="submit" class="consult-form__btn">Отправить</button>
                                    <div class="consult-form__composition">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </section>
        @if($product->sets->count())
        <section class="buy-together__wrapper">
            <div class="section-title"><span>В комплекте дешевле</span></div>
            <div class="buy-together">
                <div class="container">
                    <div class="buy-together__inner">
                        @foreach($product->sets as $i => $set)
                            <div class="buy-together__content{{ $i == 0 ? ' active' : '' }}">
                                @foreach($set->set_products as $id => $set_prod)
                                    <div class="item together-item">
                                        <div class="item-inner">
                                            <span class="item-label">Акция <i>%</i></span>
                                            <div class="item-pic__wrapper">
                                                <a href="{{env('APP_URL')}}/product/{{ $set_prod->url_alias }}"><img class="item-pic" src="{{ $set_prod->image == null ? '/assets/images/no_image.jpg' : $set_prod->image->url('product_list') }}" alt=""></a>
                                            </div>
                                            <div class="item-info__wrapper">
                                                <a class="item-link" href="">{{ $set_prod->name }}</a>
                                                @if(!empty($set_prod->old_price))
                                                    <div class="item-price-old red">{{ round($set_prod->old_price, 2) }} грн</div>
                                                @else
                                                    <div class="item-price-old" style="text-decoration: none;">&nbsp;</div>
                                                @endif
                                                <div class="item-price">{{ round($set_prod->price, 2) }} грн</div>
                                            </div>
                                        </div>
                                    </div>
                                    @if($id + 1 < $set->set_products->count())
                                    <span class="buy-together__plus">+</span>
                                    @endif
                                @endforeach
                                <span class="buy-together__equally">=</span>
                                <div class="buy-together__price-wrapper">
                                    @if(!empty($set->old_price))
                                        <div class="buy-together__price-old">{{ round($set->old_price, 2) }} грн.</div>
                                    @else
                                        <div class="buy-together__price-old" style="text-decoration: none;">&nbsp;</div>
                                    @endif
                                    <div class="buy-together__price-new">{{ round($set->price, 2) }} грн.</div>
                                    <a href="{{env('APP_URL')}}/product/{{ $set->url_alias }}" class="buy-together__btn">Заказать Комплект</a>
                                </div>
                            </div>
                        @endforeach
                        @if($product->sets->count() > 1)
                            <nav class="buy-together__tabs">
                                <span class="buy-together__tabs-title">Еще варианты:</span>
                                <ul class="buy-together__tabs-list">
                                    @foreach($product->sets as $i => $set)
                                        <li class="buy-together__tabs-item{{ $i == 0 ? ' active' : '' }}">{{ $set->name }}</li>
                                    @endforeach
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        @endif
        {{--@if($related->count())--}}
        {{--<section class="similar-items__wrapper" id="similar-products">--}}
            {{--<div class="section-title"><span>С этим товаром покупают</span></div>--}}
            {{--<div class="container">--}}
                {{--<div class="actions-slider">--}}
                    {{--@forelse($related as $related_product)--}}
                        {{--<div class="item col-sm-4">--}}
                            {{--<div class="item-inner action">--}}
                                {{--@if(!empty($product->action))--}}
                                {{--<span class="item-label">Акция <i>%</i></span>--}}
                                {{--@endif--}}
                                {{--<div class="item-pic__wrapper">--}}
                                    {{--<a href="{{env('APP_URL')}}/product/{{ $related_product->url_alias }}"><img class="item-pic" src="{{ $related_product->image == null ? '/assets/images/no_image.jpg' : $related_product->image->url('product_list') }}" alt=""></a>--}}
                                {{--</div>--}}
                                {{--<div class="item-info__wrapper">--}}
                                    {{--<a class="item-link" href="{{env('APP_URL')}}/product/{{ $related_product->url_alias }}">{{ $related_product->name }}</a>--}}
                                    {{--@if(!empty($related_product->old_price))--}}
                                        {{--<div class="item-price-old">{{ round($related_product->old_price, 2) }} грн</div>--}}
                                    {{--@else--}}
                                        {{--<div class="item-price-old" style="text-decoration: none;">&nbsp;</div>--}}
                                    {{--@endif--}}
                                    {{--<div class="item-price">{{ round($related_product->price, 2) }} грн</div>--}}
                                    {{--<a class="item-btn" href="/product/{{ $related_product->url_alias }}">Подробнее</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--@empty--}}

                    {{--@endforelse--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</section>--}}
        {{--@endif--}}
    </main>
    <div class="mfp-hide">
        <div id='quick-order-popup' class="order-popup">
            <strong class="popup-title">Купить в один клик</strong>
            <span class="popup-info">Введите Ваш номер телефона<br> и наш менеджер свяжется с Вами в ближайшее время</span>
            <form action="/sendmail" class="pbz_form clear-styles"
                  data-error-title="Ошибка отправки!"
                  data-error-message="Попробуйте отправить заявку через некоторое время."
                  data-success-title="Спасибо за заявку!"
                  data-success-message="Наш менеджер свяжется с Вами в ближайшее время.">
                <input type="tel" class="popup__input" name="phone" placeholder="Введите телефон" data-title="Телефон" data-validate-required="Обязательное поле" data-validate-phone="Неправильный номер">
                <button type="submit" class="product-order__btn">Купить</button>
            </form>
            <button title="Close (Esc)" type="button" class="mfp-close">×</button>
        </div>

        <div id="view_popup_prod" class="view-popup">
            <div class="container">
                <div class="row">
                    <div class="col-sm-offset-2 col-sm-8 col-xs-12">
                        <div class="product-slider view_popup_prod-slider">
                            @forelse($gallery as $i => $image)
                                @if(is_object($image['image']))
                                    <div data-index="{{ $i }}">
                                        <div class="img-wrp">
                                            <img src="{{ $image['image']->url() }}"{!! empty($image['alt']) ? '' : ' alt="'.$image['alt'].'"' !!}{!! empty($image['title']) ? '' : ' title="'.$image['title'].'"' !!} itemprop="image">
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <div data-index="0">
                                    <div class="img-wrp">
                                        <img src="/assets/images/no_image.jpg" alt="{{ $product->name }}">
                                    </div>
                                </div>
                            @endforelse
                            @if(!empty($product->video))
                                <div data-index="{{ isset($i) ? ($i + 1) : 0 }}">
                                    <div class="iframe-wrapper">
                                        <iframe src="{{ $product->video }}" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <button title="Close (Esc)" type="button" class="mfp-close">×</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection