@extends('public.layouts.main')
@section('meta')
    <title>{!! $settings->meta_title !!}</title>
    <meta name="description" content="{!! $settings->meta_description !!}">
    <meta name="keywords" content="{!! $settings->meta_keywords !!}">
@endsection

@section('content')
    <!-- Код тега ремаркетинга Google -->
    <script type="text/javascript">
        var google_tag_params = {
            ecomm_prodid: '',
            ecomm_pagetype: 'home',
            ecomm_totalvalue: 0,
        };
    </script>
    <script type="text/javascript">
        /* <![CDATA[ */
        var google_conversion_id = 765411960;
        var google_custom_params = window.google_tag_params;
        var google_remarketing_only = true;
        /* ]]> */
    </script>
    <script>
        dataLayer.push ({
            'event':'remarketingTriggered',
            'google_tag_params': window.google_tag_params
        });
    </script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
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
        <section class="section-7">
            <div class="section-title"><span>О Компании</span></div>

            <h1>Промышленное и грузоподъемное оборудование</h1>

            <div class="container">
                <div class="about-top__wrap">
                    <div class="about-top__pic-wrap"><picture> <source data-src="https://globalprom.com.ua/images/webp/about-pic1.webp" scrset="/images/webp/pixel.webp" type="image/webp" /> <source data-src="https://globalprom.com.ua/images/about-pic1.jpg" scrset="/images/pixel.jpg" type="image/image/jpeg" /> <img alt="about-pic1" data-src="https://globalprom.com.ua/images/about-pic1.jpg" src="/images/pixel.jpg" /> </picture></div>

                    <div class="about-top__txt-wrap"><span class="about-top__title">У нас есть все, что вы ищете и даже больше!</span>

                        <p class="about-top__txt">Ищете грузоподъемное, горно-шахтное или промышленное оборудование? Мы готовы сделать для вас выгодное предложение!</p>

                        <p class="about-top__txt">Наша компания &laquo;GlobalProm&raquo; вот уже 6 лет производит и поставляет на рынки Украины, Грузии и территорию стран бывшего СНГ производственно-технологическое оборудование и подъемное оборудование для строительства и оснащения промышленных и строительно-монтажных зон. За столь короткое время мы успели зарекомендовать себя как надежный партнер и получить множество положительных отзывов от крупнейших игроков промышленного рынка.</p>
                    </div>
                </div>

                <div class="about-bot__wrap">
                    <div class="about-top__txt-wrap"><span class="about-bot__title">Более 1000 разновидностей промышленных и грузоподъемных товаров!</span>

                        <p class="about-bot__txt">На сегодняшний день мы готовы предложить вам широкий выбор товаров, а именно разнообразное промышленное подъемное оборудование, а также промышленное производственное оборудование от компании &laquo;GlobalProm&raquo;:</p>

                        <ul class="about-bot__list">
                            <li class="about-bot__list-item">Ручные шестеренные, рычажные и червячные тали для подъема груза массой до 10 тонн;</li>
                            <li class="about-bot__list-item">Ручные и электрические лебедки, монтажно-тяговые механизмы типа МТМ, тельферы и тали электрические для горизонтального и вертикального подъема груза любой тяжести;</li>
                            <li class="about-bot__list-item">Гидравлические тележки (роклы), штабелеры и автопогрузчики для перемещения груза в цехах, на стройплощадках и в складских помещениях;</li>
                            <li class="about-bot__list-item">Промышленное весовое оборудование для взвешивания грузовых авто, железнодорожных вагонов, промышленного груза, а также крупного рогатого скота (весы для животных);</li>
                            <li class="about-bot__list-item">Промышленные грузоподъемные электрические и ручные краны для оборудования крупных строительных и монтажных площадок;</li>
                            <li class="about-bot__list-item">Промышленные редукторы, мотор-редукторы, а также электродвигатели для привода различного промышленного оборудования (мельниц, бетономешалок, конвейеров, инкубаторов, буровых установок, шнеков, экструдеров и т.д.);</li>
                            <li class="about-bot__list-item">Оборудование для горнодобывающей отросли (буровые станки, конвейеры, машины породопогрузочные, комбайны, а также шахтные скреперные лебедки);</li>
                            <li class="about-bot__list-item">Промышленные насосы для перекачивания любых видов жидкости, в том числе химикатов;</li>
                            <li class="about-bot__list-item">Промышленные вентиляторы и дымососы для проветривания и кондиционирования различных промышленных помещений, цехов и офисов.</li>
                        </ul>
                    </div>

                    <div class="about-bot__pic-wrap"><picture> <source data-src="https://globalprom.com.ua/images/webp/about-pic2.webp" scrset="/images/webp/pixel.webp" type="image/webp" /> <source data-src="https://globalprom.com.ua/images/about-pic2.jpg" scrset="/images/pixel.jpg" type="image/image/jpeg" /> <img alt="about-pic2" data-src="https://globalprom.com.ua/images/about-pic2.jpg" src="/images/pixel.jpg" /> </picture></div>
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
                                            {!! isset($article['image']) ? $article['image'] : '' !!}
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
        <section class="section-9">
            <div class="consult-wrapper">
                <div class="container">
                    <div class="col-md-7 consult-form__wrapper"><span class="consult-title">Получить грамотную консультацию специалиста и купить выбранный товар в один клик!</span>

                        <p class="consult-text">Продажа всего представленного в нашем интернет-магазине товара осуществляется напрямую с сайта или через менеджеров. Чтобы заказать выбранное оборудование или получить консультацию свяжитесь с нами.</p>

                        <form action="/sendmail" class="consult-form pbz_form clear-styles" data-error-message="Попробуйте отправить заявку через некоторое время." data-error-title="Ошибка отправки!" data-success-message="Наш менеджер свяжется с вами в ближайшее время." data-success-title="Спасибо за заявку!">
                            <div class="consult-form__composition"><input class="consult-form__input" data-validate-required="Обязательное поле" name="phone" placeholder="Введите ваш телефон" type="text" /><button class="consult-form__btn">Получить консультацию</button></div>
                        </form>
                    </div>

                    <div class="col-md-5 consult-pic__wrapper"><picture> <source data-src="/images/webp/consult-pic.webp" scrset="/images/webp/pixel.webp" type="image/webp" /> <source data-src="/images/consult-pic.jpg" scrset="/images/pixel.jpg" type="image/image/jpeg" /> <img alt="" class="consult-pic" data-src="/images/consult-pic.png" src="/images/pixel.jpg" /> </picture></div>
                </div>
            </div>
        </section>
    </main>
@endsection