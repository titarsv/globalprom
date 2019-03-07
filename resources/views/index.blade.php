@extends('public.layouts.main')
@section('meta')
    <title>{!! $settings->meta_title !!}</title>
    <meta name="description" content="{!! $settings->meta_description !!}">
    <meta name="keywords" content="{!! $settings->meta_keywords !!}">
    <!-- Код тега ремаркетинга Google -->
    <script type="text/javascript">
        var google_tag_params = {
            dynx_itemid: '',
            dynx_pagetype: 'home',
            dynx_totalvalue: '',
        };
    </script>
    <script type="text/javascript">
        /* <![CDATA[ */
        var google_conversion_id = 765411960;
        var google_custom_params = window.google_tag_params;
        var google_remarketing_only = true;
        /* ]]> */
    </script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
@endsection

@section('content')

    <main class="main-wrapper">
        <section class="section-1">
            <div class="container">
                <div class="main-title"><span>Промышленное и грузоподъемное оборудование в строго оговоренные сроки.</span><br> За каждый день просрочки выплатим неустойку в размере 2% от суммы заказа!</div>
                <div class="main-slider">
                    @foreach($slideshow as $slide)
                        <div class="main-slide">
                            <div class="col-sm-6 main-slider__pic-wrapper">
                                {{--<img class="main-slider__pic" data-lazy="/assets/images/{!! $slide->image->href !!}" alt="">--}}
                                {!! $slide->image->webp_image('banner', ['class' => 'main-slider__pic'], 'slider') !!}
                            </div>
                            <div class="col-sm-6 main-slider__info">
                                <div class="main-slider__info-inner">
                                    <div class="main-slider__title">{!! json_decode($slide->slide_data)->slide_title !!}</div>
                                    <span class="main-slider__subtitle">{!! json_decode($slide->slide_data)->slide_description !!}</span>
                                    @if($slide->enable_link)
                                        <a class="main-slider__btn" href="{!! $slide->link !!}">{!! json_decode($slide->slide_data)->button_text !!}</a>
                                    @else
                                        <button class="main-slider__btn popup_btn" data-mfp-src="{!! $slide->link !!}">{!! json_decode($slide->slide_data)->button_text !!}</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @if($actions && $actions->count() > 0)
            <section class="section-2">
                <div class="section-title"><span>Акции</span></div>
                <div class="container">
                    <div class="actions-slider">
                        @forelse($actions as $product)
                            <div class="item col-sm-4">
                                <div class="item-inner action">
                                    <span class="item-label">Акция <i>%</i></span>
                                    <div class="item-pic__wrapper">
                                        <a href="{{env('APP_URL')}}/product/{{ $product->url_alias }}">
                                            {!! $product->image->webp_image('product_list', ['alt' => $product->name, 'class' => 'item-pic'], 'slider') !!}
                                            {{--<img class="item-pic" data-lazy="{{ $product->image == null ? '/assets/images/no_image.jpg' : $product->image->url('product_list') }}" alt="">--}}
                                        </a>
                                    </div>
                                    <div class="item-info__wrapper">
                                        <a class="item-link" href="{{env('APP_URL')}}/product/{{ $product->url_alias }}">{{ $product->name }}</a>
                                        @if(!empty($product->old_price))
                                            <div class="item-price-old">{{ round($product->old_price, 2) }} грн</div>
                                        @else
                                            <div class="item-price-old" style="text-decoration: none;">&nbsp;</div>
                                        @endif
                                        <div class="item-price">{{ round($product->price, 2) }} грн</div>
                                        <a class="item-btn" href="/product/{{ $product->url_alias }}">Подробнее</a>
                                    </div>
                                </div>
                            </div>
                        @empty

                        @endforelse
                    </div>
                </div>
            </section>
        @endif
        <section class="section-3">
            <div class="section-title"><span>Наша продукция</span></div>
            <div class="container">
                <div class="categories-wrapper">
                    <a href="{{env('APP_URL')}}/categories/gruzopodemnoe-oborudovanie" class="cat-item col-md-3 col-sm-6">
                        <div class="cat-item__inner">
                            <i class="cat-item__icon cii1"></i>
                            <span class="cat-item__txt">Грузоподъемное <br>оборудование</span>
                        </div>
                        <div class="cat-item__btn">
                            <span class="cat-item__btn-inner">Перейти в категорию</span>
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/categories/promishlennoe-oborudovanie" class="cat-item col-md-3 col-sm-6">
                        <div class="cat-item__inner">
                            <i class="cat-item__icon cii2"></i>
                            <span class="cat-item__txt">Промышленное <br>оборудование</span>
                        </div>
                        <div class="cat-item__btn">
                            <span class="cat-item__btn-inner">Перейти в категорию</span>
                        </div>
                    </a>
                    {{--<a href="{{env('APP_URL')}}/categories/vesovoe-oborudovanie" class="cat-item col-md-3 col-sm-6">--}}
                        {{--<div class="cat-item__inner">--}}
                            {{--<i class="cat-item__icon cii3"></i>--}}
                            {{--<span class="cat-item__txt">Весовое <br>оборудование</span>--}}
                        {{--</div>--}}
                        {{--<div class="cat-item__btn">--}}
                            {{--<span class="cat-item__btn-inner">Перейти в категорию</span>--}}
                        {{--</div>--}}
                    {{--</a>--}}
                    {{--<a href="{{env('APP_URL')}}/categories/nasosnoe-oborudovanie" class="cat-item col-md-3 col-sm-6">--}}
                        {{--<div class="cat-item__inner">--}}
                            {{--<i class="cat-item__icon cii4"></i>--}}
                            {{--<span class="cat-item__txt">Насосное <br>оборудование</span>--}}
                        {{--</div>--}}
                        {{--<div class="cat-item__btn">--}}
                            {{--<span class="cat-item__btn-inner">Перейти в категорию</span>--}}
                        {{--</div>--}}
                    {{--</a>--}}
                </div>
            </div>
        </section>
        <section>
            <div class="team">
                <div class="team-img-wrp all-team">
                    <p class="team-title">Наша команда</p>
                    <picture data-mfp-src="/images/all-team.jpg" class="popup-btn" data-type="image">
                        <source scrset="/images/webp/pixel.webp" data-src="/images/webp/all-team.webp" type="image/webp">
                        <source scrset="/images/pixel.jpg" data-src="/images/all-team.jpg" type="image/jpg">
                        <img src="/images/pixel.jpg" data-src="/images/all-team.jpg" alt="ariston logo">
                    </picture>
                    {{--<img data-mfp-src="/images/all-team.jpg" class="popup-btn" data-type="image" src="/images/all-team.jpg" alt=""/>--}}
                    <span class="img-title">Компания GlobalProm</span>
                </div>
            </div>
            <a href="{{env('APP_URL')}}/page/o-nas" target="_blank" class="item-btn team-btn">Подробнее</a>
        </section>
        <section class="section-4">
            <div class="section-title"><span>Цифры в реальном времени</span></div>
            <div class="container">
                <div class="counters">
                    <div class="counter-wrapper col-sm-4">
                        <span class="counter-title">Товаров в наличии на складе</span>
                        <div class="odometer odometer1">0000</div>
                    </div>
                    <div class="counter-wrapper col-sm-4">
                        <span class="counter-title">Мы открыли компанию:</span>
                        <div class="odometer odometer2">0000</div>
                        <div class="counter-footnote">
                            <span>Лет</span>
                            <span></span>
                            <span>Дней</span>
                            <span></span>
                        </div>
                    </div>
                    <div class="counter-wrapper col-sm-4">
                        <span class="counter-title">Клиентов по всему миру</span>
                        <div class="odometer odometer3">0000</div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-5">
            <div class="section-title"><span>Рекомендации</span></div>
            <span class="section-subtitle">ОТ ПОСТОЯННЫХ КЛИЕНТОВ</span>
            <div class="container">
                <div class="clients-wrapper">
                    <a href="{{env('APP_URL')}}/images/cert/cert-1.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <picture>
                                <source scrset="/images/webp/pixel.webp" data-src="{{env('APP_URL')}}/images/webp/cert/min/cert-1.webp" type="image/webp">
                                <source scrset="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-1.jpg" type="image/jpg">
                                <img src="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-1.jpg" alt="">
                            </picture>
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-2.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <picture>
                                <source scrset="/images/webp/pixel.webp" data-src="{{env('APP_URL')}}/images/webp/cert/min/cert-2.webp" type="image/webp">
                                <source scrset="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-2.jpg" type="image/jpg">
                                <img src="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-2.jpg" alt="">
                            </picture>
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-3.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <picture>
                                <source scrset="/images/webp/pixel.webp" data-src="{{env('APP_URL')}}/images/webp/cert/min/cert-3.webp" type="image/webp">
                                <source scrset="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-3.jpg" type="image/jpg">
                                <img src="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-3.jpg" alt="">
                            </picture>
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-4.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <picture>
                                <source scrset="/images/webp/pixel.webp" data-src="{{env('APP_URL')}}/images/webp/cert/min/cert-4.webp" type="image/webp">
                                <source scrset="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-4.jpg" type="image/jpg">
                                <img src="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-4.jpg" alt="">
                            </picture>
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-5.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <picture>
                                <source scrset="/images/webp/pixel.webp" data-src="{{env('APP_URL')}}/images/webp/cert/min/cert-5.webp" type="image/webp">
                                <source scrset="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-5.jpg" type="image/jpg">
                                <img src="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-5.jpg" alt="">
                            </picture>
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-6.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <picture>
                                <source scrset="/images/webp/pixel.webp" data-src="{{env('APP_URL')}}/images/webp/cert/min/cert-1.webp" type="image/webp">
                                <source scrset="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-6.jpg" type="image/jpg">
                                <img src="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-6.jpg" alt="">
                            </picture>
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-7.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <picture>
                                <source scrset="/images/webp/pixel.webp" data-src="{{env('APP_URL')}}/images/webp/cert/min/cert-7.webp" type="image/webp">
                                <source scrset="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-7.jpg" type="image/jpg">
                                <img src="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-7.jpg" alt="">
                            </picture>
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-8.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <picture>
                                <source scrset="/images/webp/pixel.webp" data-src="{{env('APP_URL')}}/images/webp/cert/min/cert-8.webp" type="image/webp">
                                <source scrset="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-8.jpg" type="image/jpg">
                                <img src="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-8.jpg" alt="">
                            </picture>
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-9.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <picture>
                                <source scrset="/images/webp/pixel.webp" data-src="{{env('APP_URL')}}/images/webp/cert/min/cert-9.webp" type="image/webp">
                                <source scrset="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-9.jpg" type="image/jpg">
                                <img src="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-9.jpg" alt="">
                            </picture>
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-10.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <picture>
                                <source scrset="/images/webp/pixel.webp" data-src="{{env('APP_URL')}}/images/webp/cert/min/cert-10.webp" type="image/webp">
                                <source scrset="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-10.jpg" type="image/jpg">
                                <img src="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-10.jpg" alt="">
                            </picture>
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-11.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <picture>
                                <source scrset="/images/webp/pixel.webp" data-src="{{env('APP_URL')}}/images/webp/cert/min/cert-11.webp" type="image/webp">
                                <source scrset="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-11.jpg" type="image/jpg">
                                <img src="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-11.jpg" alt="">
                            </picture>
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-12.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <picture>
                                <source scrset="/images/webp/pixel.webp" data-src="{{env('APP_URL')}}/images/webp/cert/min/cert-12.webp" type="image/webp">
                                <source scrset="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-12.jpg" type="image/jpg">
                                <img src="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-12.jpg" alt="">
                            </picture>
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-13.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <picture>
                                <source scrset="/images/webp/pixel.webp" data-src="{{env('APP_URL')}}/images/webp/cert/min/cert-13.webp" type="image/webp">
                                <source scrset="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-13.jpg" type="image/jpg">
                                <img src="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-13.jpg" alt="">
                            </picture>
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-14.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <picture>
                                <source scrset="/images/webp/pixel.webp" data-src="{{env('APP_URL')}}/images/webp/cert/min/cert-14.webp" type="image/webp">
                                <source scrset="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-14.jpg" type="image/jpg">
                                <img src="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-14.jpg" alt="">
                            </picture>
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-15.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <picture>
                                <source scrset="/images/webp/pixel.webp" data-src="{{env('APP_URL')}}/images/webp/cert/min/cert-15.webp" type="image/webp">
                                <source scrset="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-15.jpg" type="image/jpg">
                                <img src="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-15.jpg" alt="">
                            </picture>
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-16.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <picture>
                                <source scrset="/images/webp/pixel.webp" data-src="{{env('APP_URL')}}/images/webp/cert/min/cert-16.webp" type="image/webp">
                                <source scrset="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-16.jpg" type="image/jpg">
                                <img src="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-16.jpg" alt="">
                            </picture>
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-17.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <picture>
                                <source scrset="/images/webp/pixel.webp" data-src="{{env('APP_URL')}}/images/webp/cert/min/cert-17.webp" type="image/webp">
                                <source scrset="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-17.jpg" type="image/jpg">
                                <img src="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-17.jpg" alt="">
                            </picture>
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-18.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <picture>
                                <source scrset="/images/webp/pixel.webp" data-src="{{env('APP_URL')}}/images/webp/cert/min/cert-18.webp" type="image/webp">
                                <source scrset="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-18.jpg" type="image/jpg">
                                <img src="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-18.jpg" alt="">
                            </picture>
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-19.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <picture>
                                <source scrset="/images/webp/pixel.webp" data-src="{{env('APP_URL')}}/images/webp/cert/min/cert-19.webp" type="image/webp">
                                <source scrset="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-19.jpg" type="image/jpg">
                                <img src="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-19.jpg" alt="">
                            </picture>
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-20.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <picture>
                                <source scrset="/images/webp/pixel.webp" data-src="{{env('APP_URL')}}/images/webp/cert/min/cert-20.webp" type="image/webp">
                                <source scrset="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-20.jpg" type="image/jpg">
                                <img src="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-20.jpg" alt="">
                            </picture>
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-21.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <picture>
                                <source scrset="/images/webp/pixel.webp" data-src="{{env('APP_URL')}}/images/webp/cert/min/cert-21.webp" type="image/webp">
                                <source scrset="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-21.jpg" type="image/jpg">
                                <img src="/images/pixel.jpg" data-src="{{env('APP_URL')}}/images/cert/min/cert-21.jpg" alt="">
                            </picture>
                        </div>
                    </a>
                </div>
                <div class="show-more-clients">
                    <div class="show-more-clients__btn-wrapper"><span class="show-more-clients__btn" id="show-more-clients__btn">Показать еще +</span></div>
                <span class="add-review">
                    <a class="add-review__link" href="https://docs.google.com/forms/d/e/1FAIpQLSfEioKyz3xz4yM_cIlU-7WVeq96HWgVue_SOr9LIyLJaJNk5w/viewform">Написать отзыв</a>
                </span>
                </div>
            </div>
        </section>
        <section class="section-6">
            <div class="section-title"><span>Новости и Статьи</span></div>
            <div class="container">
                <nav class="news-tabs">
                    <ul class="news-tabs__list">
                        <li class="news-tabs__item active">
                            <span class="news-tabs__item-inner">Свежие новости</span>
                        </li>
                        <li class="news-tabs__item">
                            <span class="news-tabs__item-inner">Статьи</span>
                        </li>
                    </ul>
                    <div class="news-tabs__content active">
                        @foreach($news as $i => $article)
                            <div class="col-md-6">
                                <div class="news-item">
                                    <div class="news-item__main-wrap">
                                        <div class="news-item__pic-wrap">
                                            {!! $article->image->webp_image('product_list', ['alt' => $article->name], 'static') !!}
                                            {{--<img class="news-item__pic" src="{!! $article->image->url('blog_list') !!}" alt>--}}
                                        </div>
                                        <div class="news-item__text-wrap">
                                            <a href="{{env('APP_URL')}}/news/{!! $article->url_alias !!}" class="news-item__title">{!! $article->title !!}</a>
                                            <div class="news-item__text">{!! $article->subtitle !!}</div>
                                        </div>
                                    </div>
                                    <div class="news-item__more-wrap">
                                        <a class="news-item__more-btn" href="{{env('APP_URL')}}/news/{!! $article->url_alias !!}">Читать далее...</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="clearfix"></div>
                        <div class="show-more-articles">
                            <div class="show-more-clients__btn-wrapper"></div>
                            <span class="add-review">
                                <a class="add-review__link" href="{{env('APP_URL')}}/news">Все новости</a>
                            </span>
                        </div>
                    </div>
                    <div class="news-tabs__content">
                        @foreach($articles as $i => $article)
                            <div class="col-md-6">
                                <div class="news-item">
                                    <div class="news-item__main-wrap">
                                        <div class="news-item__pic-wrap">
                                            {!! $article['image'] !!}
                                            {{--<img class="news-item__pic" src="{{env('APP_URL')}}{!! $article['image'] !!}" alt>--}}
                                        </div>
                                        <div class="news-item__text-wrap">
                                            <a href="{{env('APP_URL')}}/blog/{!! $article['post_name'] !!}/" class="news-item__title">{!! $article['post_title'] !!}</a>
                                            <div class="news-item__text">{!! strip_tags($article['post_content']) !!}</div>
                                        </div>
                                    </div>
                                    <div class="news-item__more-wrap">
                                        <a class="news-item__more-btn" href="{{env('APP_URL')}}/blog/{!! $article['post_name'] !!}/">Читать далее...</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="clearfix"></div>
                            <div class="show-more-articles">
                                <div class="show-more-clients__btn-wrapper"></div>
                                <span class="add-review">
                                <a class="add-review__link" href="{{env('APP_URL')}}/blog">Все статьи</a>
                            </span>
                        </div>
                    </div>
                </nav>
            </div>
        </section>
        {!! $settings->about !!}
    </main>
@endsection