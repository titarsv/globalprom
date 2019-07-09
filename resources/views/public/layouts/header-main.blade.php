<header class="header" id="top">
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
                        <li class="header-tabs__item active">Украина</li>
                        <li class="header-tabs__item">Грузия</li>
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
					</span>
                </div>
                <!--/noindex-->
            </div>
        </div>
    </div>
    @include('public.layouts.main-menu')
</header>