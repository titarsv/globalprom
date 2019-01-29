<!doctype html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title('«', true, 'right'); ?> <?php bloginfo('name'); ?></title>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_head(); ?>
	<!-- Вставка HTML5 поєднується з Respond.js для підтримки в IE8 елементів HTML5 та медіа-запитів -->
	    <!-- ЗАСТЕРЕЖЕННЯ: файл Respond.js не працює, якщо ви проглядаєте сторінку відкривши її з файлової системи -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
</head>
<body <?php body_class(); ?>>
<?php //wp_nav_menu(array('menu' => 'top-menu', 'menu_class' => 'nav navbar-nav navbar-left', 'container' => false)); ?>
<header class="header">
    <div class="main-header">
        <div class="container main-header__container">
            <div class="logo-wrapper col-sm-3">
                <a href="/">
                    <img class="header-logo" src="/images/logo.jpg" alt="">
                    <p>Грузоподъёмное и промышленное оборудование</p>
                </a>
            </div>
            <div class="search-wrapper col-sm-4">
                <form method="GET" action="" accept-charset="UTF-8" class="main-search">
                    <div class="search-inner">
                        <input placeholder="Поиск статей" class="search-field" name="s" type="search">
                        <button class="search-field-btn">поиск</button>
                    </div>
                </form>
            </div>
            <div class="phones-wrapper col-sm-3">
                <nav class="header-tabs">
                    <ul class="header-tabs__list">
                        <li class="header-tabs__item active">Украина</li>
                        <li class="header-tabs__item">Грузия</li>
                    </ul>
                    <div class="header-tabs__content active">
                        <ul class="header-phones__list">
							<?php $utm_source = decrypt($_COOKIE['utm_source']); ?>
							<?php if($utm_source == 'google'){ ?>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380577517063">+38 (057) 751-70-63</a>
                                </li>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380508706608">+38 (050) 870-66-08</a>
                                </li>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380671627494">+38 (067) 162-74-94</a>
                                </li>
                            <?php }elseif($utm_source == 'yandex'){ ?>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380577517062">+38 (057) 751-70-62</a>
                                </li>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380508706766">+38 (050) 870-67-66</a>
                                </li>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380671627874">+38 (067) 162-78-74</a>
                                </li>
                            <?php }elseif($utm_source == 'facebook'){ ?>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380577517059">+38 (057) 751-70-59</a>
                                </li>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380671860180">+38 (067) 186-01-80</a>
                                </li>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380663583955">+38 (066) 358 39 55</a>
                                </li>
                            <?php }else{ ?>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380577517059">+38 (057) 751-70-59</a>
                                </li>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380506972161">+38 (050) 697-21-61</a>
                                </li>
                                <li class="header-phone">
                                    <a class="header-phone__link" href="tel:+380973229908">+38 (097) 322-99-08</a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="header-tabs__content">
                        <ul class="header-phones__list">
                            <li class="header-phone">
                                <a class="header-phone__link" href="tel:+995592770761">+995 (592) 77-07-61</a>
                            </li>
                            <li class="header-phone">
                                <a class="header-phone__link" href="tel:+995595112020">+995 (595) 11-20-20</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="login-wrapper col-sm-2">
                <div class="login-inner">
                    <a href="<?php the_domain(); ?>/login" class="login-btn"></a>
                    <a href="<?php the_domain(); ?>/cart" class="cart-wrapper active"></a>
                </div>
            </div>
        </div>
    </div>
    <nav class="main-menu">
        <div class="container">
            <div class="main-menu__wrapper">
                <ul class="main-menu__list">
                    <li class="main-menu__item main-menu__btn">
                        <i class="main-menu__btn-icon"><span></span></i>
                        <span>Каталог</span>
                    </li>
					<li class="main-menu__item">
						<a class="main-menu__link" href="<?php the_domain(); ?>/categories/rasprodazha" style="color: #f55e5e; font-weight: 600;">Распродажа</a>
					</li>
                    <li class="main-menu__item">
                        <a class="main-menu__link" href="<?php the_domain(); ?>/page/o-nas">О компании</a>
                    </li>
                    <li class="main-menu__item">
                        <a class="main-menu__link" href="<?php the_domain(); ?>/page/oplata-i-dostavka">Оплата и доставка</a>
                    </li>
                    <li class="main-menu__item">
                        <a class="main-menu__link" href="<?php the_domain(); ?>/page/garanty"">Гарантии</a>
                    </li>
                    <li class="main-menu__item">
                        <a class="main-menu__link" href="<?php the_domain(); ?>/page/otzivi-klientov">Отзывы</a>
                    </li>
                    <li class="main-menu__item">
                        <a class="main-menu__link" href="<?php the_domain(); ?>/blog">Статьи</a>
                    </li>
                    <li class="main-menu__item">
                        <a class="main-menu__link" href="<?php the_domain(); ?>/page/gallery">Отгрузки</a>
                    </li>
                    <li class="main-menu__item">
                        <a class="main-menu__link" href="<?php the_domain(); ?>/page/contact-us">Контакты</a>
                    </li>
                </ul>
                <!-- <span class="menu-separate-line"></span>
                <div class="catalog-btn popup-btn" data-mfp-src="#price-popup">
                    <i class="catalog-icon"></i>
                    <span class="catalog-txt">Скачать каталог</span>
                </div> -->
            </div>
        </div>

        <?php $root_cats = get_all_cats(); ?>

        <div class="secondary-menu">
            <div class="container">
                <div class="secondary-menu__inner">
                    <ul class="secondary-menu__list">
                        <?php foreach($root_cats as $i => $item){ ?>
                            <?php if($item->status){ ?>
                            <li class="secondary-menu__item<?php $i == 0 ? '  active' : '' ?>">
                                <i class="secondary-menu__icon smi<?=$i+1?> <?=$item->url_alias?>"></i>
                                <a href="<?php the_domain(); ?>/categories/<?=$item->url_alias?>" class="secondary-menu__link"><?=str_replace(' ', ' <br>', $item->name)?></a>
                            </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                    <?php foreach($root_cats as $i => $item){ ?>
                        <?php if($item->status){ ?>
                            <div class="secondary-menu__content<?php $i == 0 ? '  active' : '' ?>">
                                <?php $childrens = $item->children; ?>
                                <div class="secondary-menu__content-left">
                                    <?php foreach($childrens as $id => $children){ ?>
                                        <?php if($id == floor(count($childrens) / 2) && count($childrens) > 1){ ?>
                                            </div>
                                            <div class="secondary-menu__content-right">
                                        <?php } ?>
                                        <ul class="secondary-menu__content-list">
                                            <li class="secondary-menu__content-title">
                                                <a href="<?php the_domain(); ?>/categories/<?=$children->url_alias?>"><?=$children->name?></a>
                                            </li>
                                            <?php $lchildrens = $children->children; ?>
                                            <?php foreach($lchildrens as $lid => $lchildren){ ?>
                                            <li class="secondary-menu__content-item">
                                                <a href="<?php the_domain(); ?>/categories/<?=$lchildren->url_alias?>"><?=$lchildren->name?></a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>
    <nav class="mobile-menu">
        <div class="container">
            <p class="mobile-menu__title">МЕНЮ</p>
            <i class="mobile-menu__btn-icon"><span></span></i>
            <ul class="mobile-menu__list">
                <li class="mobile-menu__item">
                    <span class="mobile-menu__cat-btn">Каталог<i></i></span>
                    <ul class="mobile-submenu__list">
                        <?php foreach($root_cats as $i => $item){ ?>
                            <?php if($item->status){ ?>
                                <?php $childrens = $item->children; ?>
                                <li class="mobile-submenu__item">
                                    <span class="mobile-submenu__item__wrapper"><a href="<?php the_domain(); ?>/categories/<?=$item->url_alias?>" class="mobile-submenu__link"><?=$item->name?></a><i></i></span>
                                    <div class="mobile-submenu__secondary">
                                        <?php foreach($childrens as $id => $children){ ?>
                                            <ul class="mobile-submenu__secondary-list">
                                                <li class="mobile-submenu__secondary-title">
                                                    <a href="<?php the_domain(); ?>/categories/<?=$children->url_alias?>"><?=$children->name?></a>
                                                </li>
                                                <?php $lchildrens = $children->children; ?>
                                                <?php foreach($lchildrens as $lid => $lchildren){ ?>
                                                    <li class="mobile-submenu__secondary-item">
                                                        <a href="<?php the_domain(); ?>/categories/<?=$lchildren->url_alias?>"><?=$lchildren->name?></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                    </div>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </li>
                <li class="mobile-menu__item">
                    <a class="mobile-menu__link" href="https://globalprom.com.ua/page/o-nas">О компании</a>
                </li>
                <li class="mobile-menu__item">
                    <a class="mobile-menu__link" href="https://globalprom.com.ua/page/oplata-i-dostavka">Оплата и доставка</a>
                </li>
                <li class="mobile-menu__item">
                    <a class="mobile-menu__link" href="https://globalprom.com.ua/page/garanty">Гарантии</a>
                </li>
                <li class="mobile-menu__item">
                    <a class="mobile-menu__link" href="https://globalprom.com.ua/otzivi-klientov">Отзывы</a>
                </li>
                <li class="mobile-menu__item">
                    <a class="mobile-menu__link" href="https://globalprom.com.ua/blog">Статьи</a>
                </li>
                <li class="mobile-menu__item">
                    <a class="mobile-menu__link" href="https://globalprom.com.ua/page/gallery">Отгрузки</a>
                </li>
                <li class="mobile-menu__item">
                    <a class="mobile-menu__link" href="https://globalprom.com.ua/page/contact-us">Контакты</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<nav class="breadrumbs">
    <div class="container">
        <ul class="breadrumbs-list">
            <li class="breadrumbs-item">
                <a href="/">Главная</a><i>→</i>
            </li>
            <li class="breadrumbs-item">
                Статьи
            </li>
        </ul>
    </div>
</nav>
<main class="main-wrapper">