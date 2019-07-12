<header class="header">
    <div class="main-header">
        <div class="container main-header__container">
            <div class="logo-wrapper col-sm-3">
                @if(request()->route() && request()->route()->getName() == 'home')
                    <picture>
                        <source srcset="{{env('APP_URL')}}/images/webp/logo.webp" type="image/webp">
                        <source srcset="{{env('APP_URL')}}/images/logo.png" type="image/png">
                        <img class="header-logo" src="{{env('APP_URL')}}/images/logo.png" alt="Грузоподъёмное и промышленное оборудование" title="Грузоподъёмное и промышленное оборудование">
                    </picture>
                @else
                    <a href="{{env('APP_URL')}}">
                        <picture>
                            <source srcset="{{env('APP_URL')}}/images/webp/logo.webp" type="image/webp">
                            <source srcset="{{env('APP_URL')}}/images/logo.png" type="image/png">
                            <img class="header-logo" src="{{env('APP_URL')}}/images/logo.png" alt="Грузоподъёмное и промышленное оборудование" title="Грузоподъёмное и промышленное оборудование">
                        </picture>
                    </a>
                @endif
                <p>Грузоподъёмное и промышленное оборудование</p>
            </div>
            <div class="fixed-header__menu col-sm-4">
                <ul class="main-menu__list">
                    <li class="main-menu__item main-menu__btn">
                        <i class="main-menu__btn-icon"><span></span></i>
                        <span>Продукция</span>
                    </li>
                    <li class="main-menu__item">
                        <a class="main-menu__link" href="{{env('APP_URL')}}/categories/rasprodazha" style="color: #f55e5e; font-weight: 600;">Распродажа</a>
                    </li>
                    <li class="main-menu__item">
                        <a class="main-menu__link" href="{{env('APP_URL')}}/page/o-nas">О компании</a>
                    </li>
                    <li class="main-menu__item">
                        <a class="main-menu__link" href="{{env('APP_URL')}}/page/oplata-i-dostavka">Оплата и доставка</a>
                    </li>
                </ul>
            </div>
            <div class="search-wrapper col-sm-4">
                {!! Form::open(['route' => 'search', 'class' => 'main-search']) !!}
                <div class="search-inner">
                    {!! Form::input('search', 'text', null, ['placeholder' => 'Поиск по сайту', 'class' => 'search-field', 'data-autocomplete' => 'input-search', 'autocomplete' => 'off'] ) !!}
                    <div data-output="search-results" class="search-results" style="display: none"></div>
                    <button class="search-field-btn">поиск</button>
                </div>
                {!! Form::close()!!}
            </div>
            <div class="phones-wrapper col-sm-3">
                <nav class="header-tabs">
                    <ul class="header-tabs__list">
                        <li class="header-tabs__item active">Украина<span>UA</span></li>
                        <li class="header-tabs__item">Грузия<span>GE</span></li>
                    </ul>
                    <div class="header-tabs__content active">
                        <ul class="header-phones__list">
                            @if($source == 'google')
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380577517063">+38 (057) 751-70-63</a>
                                </li>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380508706608">+38 (050) 870-66-08</a>
                                </li>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380671627494">+38 (067) 162-74-94</a>
                                </li>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="mailto:office@globalprom.com.ua">office@globalprom.com.ua</a>
                                </li>
                            @elseif($source == 'yandex')
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380577517062">+38 (057) 751-70-62</a>
                                </li>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380508706766">+38 (050) 870-67-66</a>
                                </li>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380671627874">+38 (067) 162-78-74</a>
                                </li>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="mailto:office@globalprom.com.ua">office@globalprom.com.ua</a>
                                </li>
                            @elseif($source == 'facebook')
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380577517059">+38 (057) 751-70-59</a>
                                </li>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380671860180">+38 (067) 186-01-80</a>
                                </li>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380663583955">+38 (066) 358 39 55</a>
                                </li>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="mailto:office@globalprom.com.ua">office@globalprom.com.ua</a>
                                </li>
                            @else
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380577517059">+38 (057) 751-70-59</a>
                                </li>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380506972161">+38 (050) 697-21-61</a>
                                </li>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380973229908">+38 (097) 322-99-08</a>
                                </li>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="mailto:office@globalprom.com.ua">office@globalprom.com.ua</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="header-tabs__content">
                        <ul class="header-phones__list">
                            <li class="header-phone">
                                <a class="header-phone__link" href="tel:+995591346018">+995 (591) 34-60-18</a>
                            </li>
                            <li class="header-phone">
                                <a class="header-phone__link" href="tel:+995593749165">+995 (593) 74-91-65</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="login-wrapper col-sm-2">
                <!--noindex-->
                <div class="login-inner">
                    @if($user_logged)
                        @if (in_array('admin', $user_roles) || in_array('manager', $user_roles))
                            <a href="{{env('APP_URL')}}/admin" class="login-btn"></a>
                        @else
                            <a href="{{env('APP_URL')}}/user" class="login-btn"></a>
                        @endif
                    @else
                        <a href="{{env('APP_URL')}}/login" class="login-btn"></a>
                    @endif
                    <span class="cart-wrapper active">
						@if(isset($cart) && $cart->total_quantity)
                            <i>{{ $cart->total_quantity }}</i>
                        @endif
                        <div class="cart-wrapper__sum">{{ $cart->total_price ? number_format( round($cart->total_price, 2), 0, ',', ' ' ) : '0' }} грн.</div>
					</span>
                </div>
                <!--/noindex-->
            </div>
        </div>
        <div class="container cart-items__container">
            <div class="cart-items" id="minicart">
                @include('public.layouts.minicart')
                {{--<span class="cart-items-before"></span>--}}
                {{--@if(!empty($cart->total_price))--}}
                    {{--<div class="cart-items__inner">--}}
                        {{--<ul class="cart-items__list" id="cart-items__list">--}}
                            {{--@foreach ($cart->get_products() as $code => $product)--}}
                                {{--@if(is_object($product['product']))--}}
                                    {{--<li class="cart-item">--}}
                                        {{--<div class="cart-item__pic-wrapper">--}}
                                            {{--<img class="cart-item__pic" src="{{ is_null($product['product']->image) ? '/assets/images/no_image.jpg' : $product['product']->image->url('cart') }}" alt="{{ $product['product']->name }}">--}}
                                        {{--</div>--}}
                                        {{--<a href="{{env('APP_URL')}}/product/{{ $product['product']->url_alias }}" class="cart-item__title">--}}
                                            {{--{{ $product['product']->name }}--}}
                                            {{--@if(!empty($product['variations']))--}}
                                                {{--(--}}
                                                {{--@foreach($product['variations'] as $name => $val)--}}
                                                    {{--{{ $name }}: {{ $val }};--}}
                                                {{--@endforeach--}}
                                                {{--)--}}
                                            {{--@endif--}}
                                        {{--</a>--}}
                                        {{--<div class="cart-item__count-wrapper">--}}
                                            {{--<span class="cart-item__counter">x{{ $product['quantity'] }}</span>--}}
                                        {{--</div>--}}
                                        {{--<span class="cart-item__price">{{ number_format( round($product['price'], 2), 0, ',', ' ' ) }} грн.</span>--}}
                                        {{--<span class="cart-item__del mc_item_delete" data-prod-id="{{ $code }}"></span>--}}
                                    {{--</li>--}}
                                {{--@endif--}}
                            {{--@endforeach--}}
                        {{--</ul>--}}
                        {{--<div class="cart-items__footer">--}}
                            {{--<a href="{{env('APP_URL')}}/cart" class="cart-items__btn">Оформить заказ</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--@else--}}
                    {{--<div class="cart-items__empty">Здесь пусто</div>--}}
                {{--@endif--}}
            </div>
        </div>
    </div>
    @include('public.layouts.main-menu')
</header>