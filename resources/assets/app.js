// God save the Dev

'use strict';

// if (process.env.NODE_ENV !== 'production') {
//     require('./assets/templates/layouts/index.html');
// }

// Depends
var $ = require('jquery');
require('bootstrap');

// Modules
var Forms = require('_modules/forms');
var Slider = require('_modules/slider');
var Popup = require('_modules/popup');
var Fancy_select = require('_modules/fancyselect');
// var Jscrollpane = require('_modules/jscrollpane');
// var LightGallery = require('_modules/lightgallery');
//var Jslider = require('_modules/jslider');
var Fancybox = require('_modules/fancybox');
// var Chosen = require('_modules/chosen');

var Cookies = require('js-cookie');

// счетчики
require('../../node_modules/odometer/odometer.js');

// обрезание текста
require('./modules/succinct/succinct.js');

// Stylesheet entrypoint
require('_stylesheets/header.scss');
require('_stylesheets/app.scss');

require('jquery.nicescroll');

require('_modules/jquery-ui');


// Are you ready?
$(function() {
    new Forms();
    new Popup();
    new Fancy_select();
    // new Jscrollpane();
    // new LightGallery();
    new Slider();
    //new Jslider();
    new Fancybox();
    // new Chosen();

    /* слайдер цен */
    var price_range = $('.price-range');
    if(price_range.length) {
        price_range.slider({
            min: price_range.data('min'),
            max: price_range.data('max'),
            values: price_range.data('value').split(';'),
            range: true,
            slide: function (event, ui) {
                for (var i = 0; i < ui.values.length; ++i) {
                    $('input.sliderValue[data-index=' + i + ']').val(ui.values[i]);
                    //$('.clear-filters').addClass('active');
                }

            },
            stop: function( event, ui ) {
                $('#filters').submit();
            }
        });

        $('input.sliderValue').change(function () {
            var $this = $(this);
            $('.price-range').slider('values', $this.data('index'), $this.val());
        });
    }

    $('#filters input').change(function(){
        $('#filters').submit();
    });

    /* табы хедер */
    (function($) {
        $(function() {
            $('ul.header-tabs__list').on('click', 'li:not(.active)', function() {
                $(this)
                    .addClass('active').siblings().removeClass('active')
                    .closest('nav.header-tabs').find('div.header-tabs__content').removeClass('active').eq($(this).index()).addClass('active');
            });
        });
    })(jQuery);

    /* табы меню */
    (function($) {
        $(function() {
            $('ul.secondary-menu__list').on('mouseover', 'li:not(.active)', function() {
                $(this)
                    .addClass('active').siblings().removeClass('active')
                    .closest('div.secondary-menu__inner').find('div.secondary-menu__content').removeClass('active').eq($(this).index()).addClass('active');
            });
        });
    })(jQuery);

    /* выпадающее меню */
    $('.main-menu__btn').click(function() {
        $(this).toggleClass('active');
        $('.main-menu__btn-icon').toggleClass('active');
        $('.main-wrapper').toggleClass('active');
        $('.main-footer').toggleClass('active');
        $('.secondary-menu').toggleClass('active').slideToggle();
    });

    $(document).on('click', function() {
        $('.main-menu__btn').removeClass('active');
        $('.main-menu__btn-icon').removeClass('active');
        $('.main-wrapper').removeClass('active');
        $('.main-footer').removeClass('active');
        $('.secondary-menu').removeClass('active').slideUp();
    });

    $(document).on('click', '.main-menu__btn', function() {
        return false;
    });

    $(document).on('click', '.secondary-menu', function(e) {
        e.stopPropagation();
    });

    // search

    var search_output = $('[data-output="search-results"]');

    $('[data-autocomplete="input-search"]').on('keyup focus', function(){

        var search = $(this).val();
        var target = $(this).attr('data-target');
        search_output.html('').hide();

        if (search.length > 1) {
            var data = {};
            data.search = search;
            $.ajax({
                url: '/livesearch',
                data: data,
                method: 'GET',
                dataType: 'JSON',
                success: function(resp) {
                    var html = '<ul>';
                    $.each(resp, function(i, value){
                        if (value.empty) {
                            html += '<li>';
                            html += value.empty;
                            html += '</li>';
                        } else {
                            html += '<li class="selectable" data-name="' + value.name + '" data-id="' + value.product_id + '">';
                            html += '<img src="'+value.image+'" class="found-img">';
                            html += '<a href="/product/'+value.url+'">';
                            html += value.name;
                            html += '<span>';
                            html += value.price;
                            html += ' грн';
                            html += '</span>';
                            html += '</a>';
                            html += '</li>';
                        }
                    });
                    html += '</ul>';

                    $.each(search_output, function(i, value){
                        if ($(value).attr('data-target') == target) {
                            $(value).html(html).show();
                        }
                    });

                }
            });
        } else {
            search_output.hide();
        }
    });


    // мобильное меню

    $('.mobile-menu__btn-icon').click(function() {
        $(this).toggleClass('active');
        $('.mobile-menu__list').slideToggle('200');
    });

    $('.mobile-menu__cat-btn').click(function() {
        $(this).toggleClass('active');
        $('.mobile-submenu__list').slideToggle('200');
    });

    $('.mobile-submenu__item__wrapper').click(function() {
        $(this).toggleClass('active');
        $(this).closest('.mobile-submenu__item').find('.mobile-submenu__secondary').slideToggle('200')
            .closest('.mobile-submenu__item').siblings().find('.mobile-submenu__secondary').slideUp('200')
            .closest('.mobile-submenu__item').find('.mobile-submenu__item__wrapper').removeClass('active');
    });

    // главный слайдер
    $('.main-slider').not('.slick-initialized').slick({
        speed: 700,
        slidesToShow: 1,
        slidesToScroll: 1,
        cssEase: 'linear',
        fade: true,
        dots: true,
        arrows: true,
        lazyLoad: 'ondemand',
        autoplay: true,
        autoplaySpeed: 5000
    });

    // слайдер доставка
    $('.delivery-slider').not('.slick-initialized').slick({
        speed: 700,
        slidesToShow: 6,
        slidesToScroll: 1,
        infinite: false,
        dots: false,
        arrows: true,
        lazyLoad: 'ondemand',
        nextArrow: '<div class="arrow-right"></div>',
        prevArrow: '<div class="arrow-left"></div>',
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 5
                }
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 4
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2
                }
            }
        ]
    });

    /* интерактивная карта */
    $('g').click(function(e){
        e.preventDefault();
        var id = $(this).attr('href');
        $(this).parents('.contacts-wrapper').find('.address-info, g').removeClass('active');
        $(this).addClass('active');
        $(id).addClass('active');
    });

    //$('#Map area').hover(function() {
    //    var cls = $(this).data('class');
    //    if (typeof cls !== 'undefined') {
    //        $('#mapdiv > #map-cont').removeAttr('class').addClass(cls);
    //    }
    //});
    //$('#Map area').click(function(e) {
    //    e.preventDefault();
    //    var cls = $(this).data('class');
    //    var name = $(this).data('name');
    //    if (typeof cls !== 'undefined') {
    //        $('#mapdiv > #map-cont').removeAttr('class').addClass(cls);
    //        $('.address-info').removeClass('active').eq($(this).index()).addClass('active');
    //        $('.region-input').attr('value', name);
    //    }
    //});

    /* табы контакты */
    (function($) {
        $(function() {
            $('.contacts-tabs').on('click', 'li:not(.active)', function() {
                $(this)
                    .addClass('active').siblings().removeClass('active')
                    .closest('.main-wrapper').find('.contacts-wrapper').removeClass('active').eq($(this).index()).addClass('active');
                $('.map-wrapper .map').removeClass('active').eq($(this).index()).addClass('active');
            });
        });
    })(jQuery);

    // cчетчики

    var h = $(window).height();

    $(window).scroll(function() {
        if ($('.section-4').length) {
            if (($(this).scrollTop() + h) >= $('.section-4').offset().top) {
                $('.odometer1').html(1209);
                $('.odometer2').html(5209);
                $('.odometer3').html(4789);
            }
        }
    });

    // сертификать в полный размер
    if ($('.image-popup-vertical-fit').length) {
        $('.image-popup-vertical-fit').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            mainClass: 'mfp-img-mobile',
            image: {
                verticalFit: true
            }
        });
    }

    // показать еще сертификаты

    $('#show-more-clients__btn').click(function() {
        $('#show-more-clients__btn').fadeOut('50');
        $('.clients-wrapper').slideDown('300').promise().done(function() {
            $('.clients-wrapper').addClass('active');
        });
    });

    /* табы новости */

    (function($) {
        $(function() {
            $('ul.news-tabs__list').on('click', 'li:not(.active)', function() {
                $(this)
                    .addClass('active').siblings().removeClass('active')
                    .closest('nav.news-tabs').find('div.news-tabs__content').removeClass('active').eq($(this).index()).addClass('active');
            });
        });
    })(jQuery);

    // обрезание текста

    $('.news-item__text').succinct({
        size: 200
    });

    // фильтр в каталоге

    var w = $(window).width();

    if (w < 992) {
        $('.sidebar-hiiden').hide();
        $('.sidebar-title').click(function() {
            $('.sidebar-hiiden').slideToggle('200');
        });
    }
    else {
        $('.sidebar-hiiden').removeAttr('style');
    }

    // слайдер карточка товара

    $('.product-slider').not('.slick-initialized').slick({
        speed: 700,
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: false,
        arrows: true,
        nextArrow: '<div class="arrow-right"></div>',
        prevArrow: '<div class="arrow-left"></div>',
        asNavFor: '.product-nav'
    });

    $('.product-nav').not('.slick-initialized').slick({
        speed: 700,
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: false,
        arrows: false,
        focusOnSelect: true,
        asNavFor: '.product-slider'
    });

    // табы карточка товара

    (function($) {
        $(function() {
            $('ul.product-tabs__list').on('click', 'li:not(.active)', function() {
                if($(this).find('a').length == 0) {
                    $(this)
                        .addClass('active').siblings().removeClass('active')
                        .closest('nav.product-tabs').find('div.product-tabs__content').removeClass('active').eq($(this).index()).addClass('active');
                    setTimeout(function(){
                        $('.product-tabs__content.active .actions-slider').not('.slick-initialized').slick({
                            speed: 700,
                            slidesToShow: 4,
                            slidesToScroll: 1,
                            infinite: false,
                            arrows: true,
                            lazyLoad: 'ondemand',
                            nextArrow: '<div class="arrow-right"></div>',
                            prevArrow: '<div class="arrow-left"></div>',
                            responsive: [
                                {
                                    breakpoint: 1200,
                                    settings: {
                                        slidesToShow: 3
                                    }
                                },
                                {
                                    breakpoint: 768,
                                    settings: {
                                        slidesToShow: 2
                                    }
                                },
                                {
                                    breakpoint: 480,
                                    settings: {
                                        slidesToShow: 1
                                    }
                                }
                            ]
                        });
                    }, 50);
                }
            });
        });

        $('.product-tabs__content.active .actions-slider').not('.slick-initialized').slick({
            speed: 700,
            slidesToShow: 4,
            slidesToScroll: 1,
            infinite: false,
            arrows: true,
            lazyLoad: 'ondemand',
            nextArrow: '<div class="arrow-right"></div>',
            prevArrow: '<div class="arrow-left"></div>',
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });
    })(jQuery);

    // аккордион карточки товара
    (function ($) {
        $(function () {
            $('.product-adv__collapse-btn').on('click', function () {
                console.log('here we are')
                $(this).toggleClass('open');
            });
        });
    })(jQuery);

    $('.section-2 .actions-slider').not('.slick-initialized').slick({
        speed: 700,
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: false,
        arrows: true,
        lazyLoad: 'ondemand',
        nextArrow: '<div class="arrow-right"></div>',
        prevArrow: '<div class="arrow-left"></div>',
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    // табы вместе дешевле

    (function($) {
        $(function() {
            $('ul.buy-together__tabs-list').on('click', 'li:not(.active)', function() {
                $(this)
                    .addClass('active').siblings().removeClass('active')
                    .closest('div.buy-together__inner').find('div.buy-together__content').removeClass('active').eq($(this).index()).addClass('active');
            });
        });
    })(jQuery);

    /* скроллинг */

    jQuery(document).ready(function($) {
        $('a[href^="#"]').bind('click.smoothscroll', function(e) {
            e.preventDefault();
            var target = this.hash;
            var $target = $(target);

            $('html, body').stop().animate( {
                'scrollTop': $target.offset().top - 65
            }, 1000, 'swing', function() {
                // window.location.hash = target;
            } );
        } );
    });

    // счетчик кол-во

    $('.order-popup__minus').click(function() {
        var $input = $(this).parent().find('input');
        var count = parseInt($input.val(), 10) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
    });
    $('.order-popup__plus').click(function() {
        var $input = $(this).parent().find('input');
        $input.val(parseInt($input.val(), 10) + 1);
        $input.change();
        return false;
    });

    /* корзина */

    $('.cart-wrapper').click(function(e) {
        $('.cart-items').slideToggle('200');
    });

    $(document).click(function() {
        $('.cart-items').slideUp('200');
    });

    $('.cart-wrapper').click(function(e) {
        e.stopPropagation();
    });

    $('.cart-items').click(function(e) {
        e.stopPropagation();
    });

    /* удаление из корзины */

    if ($('.order-popup__item').length != 0) {
        $('.order-popup-inner').show();
    }
    else {
        $('.order-popup-inner').hide();
        $('.order-popup__empty').css('display', 'flex');
    }

    $('.order-popup__del').click(function() {
        $(this).parent('li').slideUp('slow').promise().done(function() {
            $(this).remove();
            if ($('.order-popup__item').length != 0) {
                $('.order-popup-inner').show();
            }
            else {
                $('.order-popup-inner').hide();
                $('.order-popup__empty').css('display', 'flex');
            }
        });
    });

    if ($('.cart-item').length != 0) {
        $('.cart-items__inner').show();
    }
    else {
        $('.cart-items__inner').hide();
        $('.cart-items__empty').css('display', 'flex');
    }

    $('.cart-item__del').click(function() {
        $(this).parent('li').slideUp('slow').promise().done(function() {
            $(this).remove();
            if ($('.cart-item').length != 0) {
                $('.cart-items__inner').show();
            }
            else {
                $('.cart-items__inner').hide();
                $('.cart-items__empty').css('display', 'flex');
            }
        });
    });

    if ($('.order-page__item').length != 0) {
        $('.order-page-inner').show();
    }
    else {
        $('.order-page-inner').hide();
        $('.order-page__empty').css('display', 'flex');
    }

    //$('.order-page__del').click(function() {
    //    $(this).parent('li').slideUp('slow').promise().done(function() {
    //        $(this).remove();
    //        if ($('.order-page__item').length != 0) {
    //            $('.order-page-inner').show();
    //        }
    //        else {
    //            $('.order-page-inner').hide();
    //            $('.order-page__empty').css('display', 'flex');
    //        }
    //    });
    //});

    // FAQ

    (function($) {
        $(function() {
            $('.faq-list').on('click', 'li:not(.active) .faq-title__wpapper', function() {
                $(this)
                    .parent().addClass('active').find('.faq-block').slideDown('300').parent().siblings().removeClass('active').find('.faq-block').slideUp('300');
            });
            $('.faq-list').on('click', 'li.active .faq-title__wpapper', function() {
                $(this).parent().removeClass('active').find('.faq-block').slideUp('300');
            });
        });
    })(jQuery);

    // табы отгрузки

    (function($) {
        $(function() {
            $('.shipments-list').on('click', 'li:not(.active)', function() {
                var count = $(this).find('.shipments-content li').length;
                $(this)
                    .addClass('active').siblings().removeClass('active')
                    .closest('.shipments-wrapper').find('.shipments-content').removeAttr('style')
                    .closest('.shipments-content__wrapper').removeClass('active').eq($(this).index()).addClass('active')
                    .closest('.shipments-content__wrapper').find('.shipments-btn-more').removeClass('hidden');
            });
        });
    })(jQuery);

    // показать еще оборудование

    $('.shipments-btn-more').click(function() {
        $(this).addClass('hidden');
        $(this).closest('.shipments-content__wrapper').find('.shipments-content').slideDown('300').promise().done(function() {
            $(this).css('height', 'max-content');
        });
    });

    // попап отгрузки

    $('.shipments-block').click(function() {
        var cls = $(this).data('class');
        var src = $(this).find('.shipments-pic').attr('src');
        $('.shipments-popup__pic-wrapper').html('<img class="shipments-popup__pic" src="' + src + '" alt="">');
        $('.shipments-popup__title').html($(this).data('title') + ' ' + $(this).data('id'));
        $('.shipments-popup__type').html($(this).data('title'));
    });

    // скролл

    $('.testimonials-list__wrapper').niceScroll();

    // табы заказ

    (function($) {
        $(function() {
            $('.order-page__forms-tabs__list').on('click', 'li:not(.active)', function() {
                $(this)
                    .addClass('active').siblings().removeClass('active')
                    .closest('.order-page__forms-tabs').find('.order-page__forms-tabs__content').removeClass('active').eq($(this).index()).addClass('active');
            });
        });
    })(jQuery);

    // табы доставка

    (function($) {
        $(function() {
            $('.delivery-info-list').on('click', 'li:not(.active)', function() {
                $(this)
                    .addClass('active').siblings().removeClass('active')
                    .closest('.delivery-form').find('.delivery-content').removeClass('active').eq($(this).index()).addClass('active');
            });
        });
    })(jQuery);

    /* табы статьи */
    (function($) {
        $(function() {
            $('js-tabs').on('click', 'li:not(.newsTabs-active)', function() {
                $(this)
                    .addClass('newsTabs-active').siblings().removeClass('newsTabs-active')
                    .closest('.newsTabs-active').find('newsTabs-content').removeClass('newsTabs-active').eq($(this).index()).addClass('newsTabs-active');
            });
        });
    })(jQuery);
    $('#exit_cont').mouseover(function() {
        if (typeof Cookies.get('exit') == 'undefined') {
            $.magnificPopup.open({
                items: {
                    src: '#exit-popup'
                },
                type: 'inline'
            }, 0);
            Cookies.set('exit', 1, {expires: 1});
        }
    });
    $('.product-slider').click(function(){
        var number = $(this).data('index');
        setTimeout(function(){
          $('.view_popup_prod-slider').slick('slickGoTo', number);
        }, 500);
    });
    $('#catalog_link').click(function(e){
        var data = $(this).parents('form').formData({
            validator: {},
            invalid: function(data) {
                for (var name in data.errors) {
                    data.obj[name].obj.validateTooltip({
                        text: data.obj[name].obj.rules[data.errors[name][0]]
                    });
                }
            }
        });
        if (data === false){
            e.preventDefault();
            return false;
        } else {
            $(this).parents('form').submit();
        }
    });
    document.oncopy = function () { var bodyElement = document.body; var selection = getSelection(); var href = document.location.href; var copyright = "<br><br>Источник: <a href='"+ href +"'>" + href + "</a><br>© Globalprom"; var text = selection + copyright; var divElement = document.createElement('div'); divElement.style.position = 'absolute'; divElement.style.left = '-99999px'; divElement.innerHTML = text; bodyElement.appendChild(divElement); selection.selectAllChildren(divElement); setTimeout(function() { bodyElement.removeChild(divElement); }, 0); };
});

require('./custom.js');