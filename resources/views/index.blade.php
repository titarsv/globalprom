@extends('public.layouts.main')
@section('meta')
    <title>{!! $settings->meta_title !!}</title>
    <meta name="description" content="{!! $settings->meta_description !!}">
    <meta name="keywords" content="{!! $settings->meta_keywords !!}">
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
                                <img class="main-slider__pic" src="/assets/images/{!! $slide->image->href !!}" alt="">
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
                                        <a href="{{env('APP_URL')}}/product/{{ $product->url_alias }}"><img class="item-pic" src="{{ $product->image == null ? '/assets/images/no_image.jpg' : $product->image->url('product_list') }}" alt=""></a>
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
                            <img class="clients-item__cert" src="/images/cert/min/cert-1.jpg" alt="">
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-2.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <img class="clients-item__cert" src="/images/cert/min/cert-2.jpg" alt="">
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-3.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <img class="clients-item__cert" src="/images/cert/min/cert-3.jpg" alt="">
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-4.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <img class="clients-item__cert" src="/images/cert/min/cert-4.jpg" alt="">
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-5.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <img class="clients-item__cert" src="/images/cert/min/cert-5.jpg" alt="">
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-6.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <img class="clients-item__cert" src="/images/cert/min/cert-6.jpg" alt="">
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-7.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <img class="clients-item__cert" src="/images/cert/min/cert-7.jpg" alt="">
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-8.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <img class="clients-item__cert" src="/images/cert/min/cert-8.jpg" alt="">
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-9.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <img class="clients-item__cert" src="/images/cert/min/cert-9.jpg" alt="">
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-10.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <img class="clients-item__cert" src="/images/cert/min/cert-10.jpg" alt="">
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-11.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <img class="clients-item__cert" src="/images/cert/min/cert-11.jpg" alt="">
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-12.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <img class="clients-item__cert" src="/images/cert/min/cert-12.jpg" alt="">
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-13.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <img class="clients-item__cert" src="/images/cert/min/cert-13.jpg" alt="">
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-14.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <img class="clients-item__cert" src="/images/cert/min/cert-14.jpg" alt="">
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-15.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <img class="clients-item__cert" src="/images/cert/min/cert-15.jpg" alt="">
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-16.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <img class="clients-item__cert" src="/images/cert/min/cert-16.jpg" alt="">
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-17.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <img class="clients-item__cert" src="/images/cert/min/cert-17.jpg" alt="">
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-18.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <img class="clients-item__cert" src="/images/cert/min/cert-18.jpg" alt="">
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-19.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <img class="clients-item__cert" src="/images/cert/min/cert-19.jpg" alt="">
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-20.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <img class="clients-item__cert" src="/images/cert/min/cert-20.jpg" alt="">
                        </div>
                    </a>
                    <a href="{{env('APP_URL')}}/images/cert/cert-21.jpg" class="clients-item image-popup-vertical-fit">
                        <div class="clients-item__cert-wrapper">
                            <span class="clients-item__zoom"></span>
                            <img class="clients-item__cert" src="/images/cert/min/cert-21.jpg" alt="">
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
                                            <img class="news-item__pic" src="{!! $article->image->url('blog_list') !!}" alt>
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
                                            <img class="news-item__pic" src="{{env('APP_URL')}}{!! $article['image'] !!}" alt>
                                        </div>
                                        <div class="news-item__text-wrap">
                                            <a href="{{env('APP_URL')}}/blog/{!! $article['post_name'] !!}/" class="news-item__title">{!! $article['post_title'] !!}</a>
                                            <div class="news-item__text">{!! $article['post_content'] !!}</div>
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
        <section class="section-7">
            <div class="section-title"><span>О Компании</span></div>
            <h1>Промышленное и грузоподъемное оборудование</h1>
            <div class="container">
                <div class="about-top__wrap">
                    <div class="about-top__pic-wrap">
                        <img src="/images/about-pic1.jpg" alt="about-pic1">
                    </div>
                    <div class="about-top__txt-wrap">
                        <span class="about-top__title">У нас есть все, что вы ищете и даже больше!</span>
                        <p class="about-top__txt">Ищете грузоподъемное, горно-шахтное или промышленное оборудование? Мы готовы сделать для вас выгодное предложение!</p>
                        <p class="about-top__txt">Наша компания «GlobalProm» вот уже 6 лет производит и поставляет на рынки Украины, Грузии и территорию стран бывшего СНГ производственно-технологическое оборудование и подъемное оборудование для строительства и оснащения промышленных и строительно-монтажных зон. За столь короткое время мы успели зарекомендовать себя как надежный партнер и получить множество положительных отзывов от крупнейших игроков промышленного рынка.</p>
                    </div>
                </div>
                <div class="about-bot__wrap">
                    <div class="about-top__txt-wrap">
                        <span class="about-bot__title">Более 1000 разновидностей промышленных и грузоподъемных товаров!</span>
                        <p class="about-bot__txt">На сегодняшний день мы готовы предложить вам широкий выбор товаров, а именно разнообразное промышленное подъемное оборудование, а также промышленное производственное оборудование от компании «GlobalProm»:</p>
                        <ul class="about-bot__list">
                            <li class="about-bot__list-item">
                                <i class="about-bot__list-marker"></i>
                                Ручные шестеренные, рычажные и червячные тали для подъема груза массой до 10 тонн;
                            </li>
                            <li class="about-bot__list-item">
                                <i class="about-bot__list-marker"></i>
                                Ручные и электрические лебедки, монтажно-тяговые механизмы типа МТМ, тельферы и тали электрические для горизонтального и вертикального подъема груза любой тяжести;
                            </li>
                            <li class="about-bot__list-item">
                                <i class="about-bot__list-marker"></i>
                                Гидравлические тележки (роклы), штабелеры и автопогрузчики для перемещения груза в цехах, на стройплощадках и в складских помещениях;
                            </li>
                            <li class="about-bot__list-item">
                                <i class="about-bot__list-marker"></i>
                                Промышленное весовое оборудование для взвешивания грузовых авто, железнодорожных вагонов, промышленного груза, а также крупного рогатого скота (весы для животных);
                            </li>
                            <li class="about-bot__list-item">
                                <i class="about-bot__list-marker"></i>
                                Промышленные грузоподъемные электрические и ручные краны для оборудования крупных строительных и монтажных площадок;
                            </li>
                            <li class="about-bot__list-item">
                                <i class="about-bot__list-marker"></i>
                                Промышленные редукторы, мотор-редукторы, а также электродвигатели для привода различного промышленного оборудования (мельниц, бетономешалок, конвейеров, инкубаторов, буровых установок, шнеков, экструдеров и т.д.);
                            </li>
                            <li class="about-bot__list-item">
                                <i class="about-bot__list-marker"></i>
                                Оборудование для горнодобывающей отросли (буровые станки, конвейеры, машины породопогрузочные, комбайны, а также шахтные скреперные лебедки);
                            </li>
                            <li class="about-bot__list-item">
                                <i class="about-bot__list-marker"></i>
                                Промышленные насосы для перекачивания любых видов жидкости, в том числе химикатов;
                            </li>
                            <li class="about-bot__list-item">
                                <i class="about-bot__list-marker"></i>
                                Промышленные вентиляторы и дымососы для проветривания и кондиционирования различных промышленных помещений, цехов и офисов.
                            </li>
                        </ul>
                    </div>
                    <div class="about-bot__pic-wrap">
                        <img src="/images/about-pic2.jpg" alt="about-pic2">
                    </div>
                </div>
            </div>
        </section>
        <section class="section-8">
            <div class="section-title"><span>Почему сотрудничать с «GlobalProm» выгодно?</span></div>
            <span class="section-subtitle">10 фактов в нашу пользу:</span>
            <div class="container cooperation-wrapper">
                <ul class="cooperation-list col-md-6">
                    <li class="cooperation-item">
                        <span class="cooperation-num">1<i class="cooperation-mark red"></i></span>
                        <p class="cooperation-text">
                            <strong>Конкурентная стоимость оборудования</strong> – так как мы являемся прямыми поставщиками заводов-производителей и не работаем с посредниками, мы готовы предоставить вам наиболее выгодные цены на все производственное оборудование.
                        </p>
                    </li>
                    <li class="cooperation-item">
                        <span class="cooperation-num">2<i class="cooperation-mark red"></i></span>
                        <p class="cooperation-text">
                            <strong>Большой выбор товаров</strong> – возможность купить все необходимое в одном месте и получить дополнительные скидки на объеме.
                        </p>
                    </li>
                    <li class="cooperation-item">
                        <span class="cooperation-num">3<i class="cooperation-mark red"></i></span>
                        <p class="cooperation-text">
                            <strong>Наличие паспортов и сертификатов</strong> – качество товара заверено сертификатами качества.
                        </p>
                    </li>
                    <li class="cooperation-item">
                        <span class="cooperation-num">4<i class="cooperation-mark red"></i></span>
                        <p class="cooperation-text">
                            <strong>Грамотная консультация</strong> – возможность проконсультироваться с техническими специалистами при выборе любого оборудования.
                        </p>
                    </li>
                    <li class="cooperation-item">
                        <span class="cooperation-num">5<i class="cooperation-mark red"></i></span>
                        <p class="cooperation-text">
                            <strong>Удобство оплаты</strong> – вы можете самостоятельно выбрать наиболее приемлемый для вас вариант оплаты товара: наличными, банковским переводом или наложенным платежом.
                        </p>
                    </li>
                </ul>
                <ul class="cooperation-list col-md-6">
                    <li class="cooperation-item">
                        <span class="cooperation-num">6<i class="cooperation-mark green"></i></span>
                        <p class="cooperation-text">
                            <strong>Работаем без задержек</strong> – при условии наличия товара на складе, его отгрузка осуществляется строго в день оплаты.
                        </p>
                    </li>
                    <li class="cooperation-item">
                        <span class="cooperation-num">7<i class="cooperation-mark green"></i></span>
                        <p class="cooperation-text">
                            <strong>Доставка в любую точку Украины и стран СНГ</strong> – доставка по Украине в течение 2-3 дней (в зависимости от выбранного перевозчика), до 2-х недель – в страны бывшего СНГ.
                        </p>
                    </li>
                    <li class="cooperation-item">
                        <span class="cooperation-num">8<i class="cooperation-mark green"></i></span>
                        <p class="cooperation-text">
                            <strong>Официальная гарантия</strong> – на весь представленный на сайте товар предоставляется официальная гарантия производителя от 6 до 36 месяцев.
                        </p>
                    </li>
                    <li class="cooperation-item">
                        <span class="cooperation-num">9<i class="cooperation-mark green"></i></span>
                        <p class="cooperation-text">
                            <strong>Оптом выгодней</strong> – оптовым покупателям предоставляются специальные скидки на постоянной основе.
                        </p>
                    </li>
                    <li class="cooperation-item">
                        <span class="cooperation-num">10<i class="cooperation-mark green"></i></span>
                        <p class="cooperation-text">
                            <strong>Скидки постоянным клиентам</strong> – специальная бонусная программа для постоянных клиентов.
                        </p>
                    </li>
                </ul>
            </div>
        </section>
        <section class="section-9">
            <div class="consult-wrapper">
                <div class="container">
                    <div class="col-md-7 consult-form__wrapper">
                        <span class="consult-title">Получить грамотную консультацию специалиста и купить выбранный товар в один клик!</span>
                        <p class="consult-text">Продажа всего представленного в нашем интернет-магазине товара осуществляется напрямую с сайта или через менеджеров. Чтобы заказать выбранное оборудование или получить консультацию свяжитесь с нами.</p>
                        <form action="/sendmail" class="consult-form pbz_form clear-styles" data-error-title="Ошибка отправки!" data-error-message="Попробуйте отправить заявку через некоторое время." data-success-title="Спасибо за заявку!" data-success-message="Наш менеджер свяжется с вами в ближайшее время.">
                            <div class="consult-form__composition">
                                <input class="consult-form__input" type="text" name="phone" data-validate-required="Обязательное поле" placeholder="Введите ваш телефон">
                                <button class="consult-form__btn">Получить консультацию</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-5 consult-pic__wrapper">
                        <img class="consult-pic" src="../../images/consult-pic.png" alt="">
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection