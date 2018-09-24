<nav class="main-menu">
    <div class="container">
        <div class="main-menu__wrapper">
            <ul class="main-menu__list">
                <li class="main-menu__item main-menu__btn">
                    <i class="main-menu__btn-icon"><span></span></i>
                    <span>Каталог</span>
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
                <li class="main-menu__item">
                    <a class="main-menu__link" href="{{env('APP_URL')}}/page/garanty">Гарантии</a>
                </li>
                <li class="main-menu__item">
                    <a class="main-menu__link" href="{{env('APP_URL')}}/page/otzivi-klientov">Отзывы</a>
                </li>
                <li class="main-menu__item">
                    <a class="main-menu__link" href="{{env('APP_URL')}}/blog">Статьи</a>
                </li>
                <li class="main-menu__item">
                    <a class="main-menu__link" href="{{env('APP_URL')}}/page/gallery">Отгрузки</a>
                </li>
                <li class="main-menu__item">
                    <a class="main-menu__link" href="{{env('APP_URL')}}/page/contact-us">Контакты</a>
                </li>
            </ul>
            {{--<span class="menu-separate-line"></span>--}}
            {{--<div class="catalog-btn popup-btn" data-mfp-src="#price-popup">--}}
            {{--<i class="catalog-icon"></i>--}}
            {{--<span class="catalog-txt">Скачать прайс</span>--}}
            {{--</div>--}}
        </div>
    </div>
    <div class="secondary-menu">
        <div class="container">
            <div class="secondary-menu__inner">
                <ul class="secondary-menu__list">
                    @foreach($items as $i => $item)
                        @if($item->status && $item->name != 'Распродажа')
                            <li class="secondary-menu__item{{ $i == 0 ? '  active' : '' }}">
                                <i class="secondary-menu__icon smi{{ $i+1 }} {{ $item->url_alias }}"></i>
                                <a href="{{env('APP_URL')}}/categories/{{ $item->url_alias }}" class="secondary-menu__link">{!! str_replace(' ', ' <br>', $item->name) !!}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
                @foreach($items as $i => $item)
                    @if($item->status && $item->name != 'Распродажа')
                        <div class="secondary-menu__content{{ $i == 0 ? '  active' : '' }}">
                            <?php $childrens = $item->children()->where('status', 1)->get(); ?>
                            <div class="secondary-menu__content-left">
                                @foreach($childrens->where('status', 1) as $id => $children)
                                    @if($id == floor(count($childrens) / 2) && count($childrens) > 1)
                            </div>
                            <div class="secondary-menu__content-right">
                                @endif
                                <ul class="secondary-menu__content-list">
                                    <li class="secondary-menu__content-title">
                                        <a href="{{env('APP_URL')}}/categories/{{ $children->url_alias }}">{{ $children->name }}</a>
                                    </li>
                                    <?php $lchildrens = $children->children()->where('status', 1)->get(); ?>
                                    @foreach($lchildrens as $lid => $lchildren)
                                        <li class="secondary-menu__content-item">
                                            <a href="{{env('APP_URL')}}/categories/{{ $lchildren->url_alias }}">{{ $lchildren->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</nav>
<nav class="mobile-menu">
    <div class="container">
        <i class="mobile-menu__btn-icon"><span></span></i>
        <ul class="mobile-menu__list">
            <li class="mobile-menu__item">
                <span class="mobile-menu__cat-btn">Каталог<i></i></span>
                <ul class="mobile-submenu__list">
                    @foreach($items as $i => $item)
                        @if($item->status && $item->name != 'Распродажа')
                            <li class="mobile-submenu__item">
                                <span class="mobile-submenu__item__wrapper"><a href="{{env('APP_URL')}}/categories/{{ $item->url_alias }}" class="mobile-submenu__link">{{ $item->name }}</a><i></i></span>
                                <div class="mobile-submenu__secondary">
                                    <?php $childrens = $item->children()->where('status', 1)->get(); ?>
                                    @foreach($childrens as $id => $children)
                                        <ul class="mobile-submenu__secondary-list">
                                            <li class="mobile-submenu__secondary-title">
                                                <a href="{{env('APP_URL')}}/categories/{{ $children->url_alias }}">{{ $children->name }}</a>
                                            </li>
                                            <?php $lchildrens = $children->children; ?>
                                            @foreach($lchildrens as $lid => $lchildren)
                                                <li class="mobile-submenu__secondary-item">
                                                    <a href="{{env('APP_URL')}}/categories/{{ $lchildren->url_alias }}">{{ $lchildren->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endforeach
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
            <li class="mobile-menu__item">
                <a class="mobile-menu__link" href="{{env('APP_URL')}}/categories/rasprodazha" style="font-weight: 600;">Распродажа</a>
            </li>
            <li class="mobile-menu__item">
                <a class="mobile-menu__link" href="{{env('APP_URL')}}/page/o-nas">О компании</a>
            </li>
            <li class="mobile-menu__item">
                <a class="mobile-menu__link" href="{{env('APP_URL')}}/page/oplata-i-dostavka">Оплата и доставка</a>
            </li>
            <li class="mobile-menu__item">
                <a class="mobile-menu__link" href="{{env('APP_URL')}}/page/garanty">Гарантии</a>
            </li>
            <li class="mobile-menu__item">
                <a class="mobile-menu__link" href="{{env('APP_URL')}}/page/otzivi-klientov">Отзывы</a>
            </li>
            <li class="mobile-menu__item">
                <a class="mobile-menu__link" href="{{env('APP_URL')}}/blog">Статьи</a>
            </li>
            <li class="mobile-menu__item">
                <a class="mobile-menu__link" href="{{env('APP_URL')}}/page/gallery">Отгрузки</a>
            </li>
            <li class="mobile-menu__item">
                <a class="mobile-menu__link" href="{{env('APP_URL')}}/page/contact-us">Контакты</a>
            </li>
        </ul>
    </div>
</nav>