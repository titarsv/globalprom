'use strict';
// Depends
var $ = require('jquery');
var swal = require('sweetalert2');

// Are you ready?
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

  // Выбор вариации
  $('.variation-select, .result-price .count_field').change(function(){
      // var result_price = parseFloat($('.product-price').data('price'));
      // var hash = '';
      // $('.variation-select').each(function(){
      //     var val = $(this).val();
      //     result_price += parseFloat($(this).find('option[value="'+val+'"]').data('price'));
      //     if(val != '' && hash != ''){
      //         hash += '-';
      //     }
      //     hash += val;
      // });
      // $('.product-price').html(result_price + ' грн.');
      // if(hash != ''){
      //     location.hash = hash;
      // }else{
      //     history.pushState("", document.title, window.location.pathname + window.location.search);
      // }

      var result_price = parseFloat($('.product-price').data('price'));
      var hash = '';
      var attrs = [];
      $('.variation-select').each(function(){
          var val = $(this).val();
          if(val != ''){
              attrs.push(val);
          }
      });
      hash = attrs.sort().join('_');

      $('[name="variation"]').prop('checked', false);
      var input = $('#var_'+hash);
      if(hash != '' && input.length){
          input.prop('checked', true);
          location.hash = hash;
          var price = parseFloat(input.data('price'));
          $('.product-price').html(price + ' грн.');
          var result_price = price * parseInt($('.result-price .count_field').val());
          $('.result-product-price').html(result_price + ' грн.');
          $('.result-product-price-wrapper').show();
      }else{
          if($('.variation-select').length == 0){
              var price = parseFloat($('.product-price').data('price'));
              var result_price = price * parseInt($('.result-price .count_field').val());
              $('.result-product-price').html(result_price + ' грн.');
              $('.result-product-price-wrapper').show();
          }else{
              if(window.location.hash !== '')
                history.pushState("", document.title, window.location.pathname + window.location.search);
              $('.product-price').html($('.product-price').data('price') + ' грн.');
              $('.result-product-price-wrapper').hide();
              if($(this).hasClass('variation-select')){
                  flushNextSelects($(this));
                  $('.result-price .count_field').change();
              }
          }
      }
      hideVariationOptions();
  });

  function flushNextSelects(select){
      var selects = $('.variation-select');
      for(var i=selects.index(select)+1; i<selects.length; i++){
          selects.eq(i).find('option:first-child').prop('selected', true);
      }
  }

  function clearVariations(variations, attrs, attr){
      var new_variations = [];
      for(var v=0; v<variations.length; v++){
          var isset = true;
          if(variations[v].indexOf(attr) < 0){
              isset = false;
          }
          for(var a=0; a<attrs.length; a++){
              if(variations[v].indexOf(attrs[a]) < 0 ){
                  isset = false;
              }
          }
          if(isset){
              new_variations.push(variations[v]);
          }
      }
      return new_variations;
  }

  function hideVariationOptions(){
      var variations = [];
      var current_select;
      $('[name="variation"]').each(function(){
          variations.push($(this).attr('id').replace('var_', ''));
      });
      var selects = $('.variation-select');
      var attrs = [];
      if(selects.length > 1){
          if(selects.eq(0).val() !== '')
            attrs.push(selects.eq(0).val());

          for(var i=1; i<selects.length; i++){
              current_select = selects.eq(i);
              current_select.find('option').each(function(){
                var opt_var = clearVariations(variations, attrs, $(this).val());
                if(opt_var.length == 0){
                    $(this).attr('disabled', 'disabled').css('display', 'none');
                    if(current_select.val() == $(this).val()){
                        current_select.find('option:first-child').prop('selected', true);
                    }
                }else{
                    $(this).prop('disabled', false).css('display', 'block');
                }
            });
            if(selects.eq(i).val() !== ''){
                attrs.push(selects.eq(i).val());
            }else{
                // i++;
                // while(i<selects.length){
                //     console.log(selects.eq(i));
                //     selects.eq(i).find('option').prop('disabled', false).css('display', 'block');
                //     i++;
                // }
                // break;
            }
          }
      }
  }

    var hash_parts = location.hash.replace('#', '').split('_');
    if(hash_parts.length){
        for(var i=0; i<hash_parts.length; i++){
            var option = $('.variation-select option[value="'+hash_parts[i]+'"]');
            option.prop('selected', true);
        }
        $('.variation-select').trigger('change');
    }


    $('.btn_buy').click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        var $this = $(this);
        var qty = $('.result-price .count_field').val();
        var data = {
            action: 'add',
            product_id: $this.data('prod-id'),
            quantity: qty > 1 ? qty : 1
        };

        var variation = $('[name="variation"]:checked');
        if(variation.length){
            data['variation'] = variation.val();
        }

        $.post("/cart/update", data, function(cart){
            $("#order-popup").html(cart.html.popup_cart);
            $("#minicart").html(cart.html.minicart);
            $.magnificPopup.open({
                items: {
                    src: '#order-popup'
                },
                type: 'inline'
            }, 0);
            update_cart_quantity();

            if(typeof fbq !== 'undefined' && typeof fbqProductsData[data.product_id] !== 'undefined'){
                fbq('track', 'AddToCart', fbqProductsData[data.product_id]);
            }
        }, 'json');

        // $("#order-popup").load("/cart/update", data, function(cart){
        //     $.magnificPopup.open({
        //         items: {
        //             src: '#order-popup'
        //         },
        //         type: 'inline'
        //     }, 0);
        //     update_cart_quantity();
        //
        //     if(typeof fbq !== 'undefined' && typeof fbqProductsData[data.product_id] !== 'undefined'){
        //         fbq('track', 'AddToCart', fbqProductsData[data.product_id]);
        //     }
        // });
    });

    /*
     * Добавление отзывов комментариев
     */
    $('form.review-form, form.answer-form').on('submit', function(e){
        e.preventDefault();
        var $this = $(this);

        $.ajax({
            url: '/review/add',
            data: $(this).serialize(),
            method: 'post',
            dataType: 'json',
            beforeSend: function() {
                $this.find('.error-message').fadeOut(300);
                $this.find('button[type="submit"]').html('Отправляем...');
            },
            success: function (response) {
                if(response.error){
                    var html = '';
                    $.each(response.error, function(i, value){
                        html += value + '<br>';
                    });
                    $('#error-' + response.type + ' > div').html(html);
                    $('#error-' + response.type).fadeIn(300);
                } else if(response.success) {
                    $('#error-' + response.type + ' > div').html(response.success);
                    $('#error-' + response.type).fadeIn(300);

                    setTimeout(function(){
                        $this.slideUp('slow');
                        $('.review-btn').fadeIn('slow');
                    },2500);
                    $('form.' + response.type + '-form')[0].reset();
                }
                $this.find('button[type="submit"]').html('Оставить отзыв')
            }
        });
    });

    window.sortBy = function(sort){
        var locate = location.search.split('&');
        var new_location = '';

        jQuery.each(locate, function (i, value) {
            var parameters = value.split('=');
            if (parameters[0] != 'sort') {
                new_location += value + '&';
            }
        });

        location.search = new_location + 'sort=' + sort;
    };

    /**
     * Отображение полей в зависимости от выбранного способа доставки
     */
    $('.order-page__form').on('change', '#checkout-step__delivery', function(){
        if ($(this).val() != 0) {
            $('.checkout-step__body').addClass('checkout-step__body_loader');
            $('.checkout-step__body_second .error-message').fadeOut(300);
            $('.checkout-step__body_second .error-message__text').html('');
            var data = {
                delivery: $(this).val(),
                order_id: $('#current_order_id').val()
            };

            $("#checkout-delivery-payment").load("/checkout/delivery", data, function (cart) {
                //$('select').fancySelect();
            });
            $('.checkout-step__body').removeClass('checkout-step__body_loader');
        }
    });

    /**
     * Удаление товара из корзины
     */
    $('#order-popup, #order_cart_content, #minicart').on('click', '.mc_item_delete', function(){
        var $this = $(this);
        update_cart({
            action: 'remove',
            product_id: $this.data('prod-id')
        });
        $(this).parent('li').slideUp('slow').promise().done(function() {
            $(this).remove();
            if ($('.order-page__item').length != 0) {
                $('.order-page-inner').show();
            }
            else {
                $('.order-page-inner').hide();
                $('.order-page__empty').css('display', 'flex');
            }
        });
    });

    /**
     * Обновление колличества товара в корзине
     */
    $('#order-popup, #order_cart_content').on('input change', '.count_field', function(){
        var $this = $(this);
        update_cart({
            action: 'update',
            product_id: $this.data('prod-id'),
            quantity: $this.val()
        });
    });

    $('.login-inner .cart-wrapper').click(function(){
        $.post("/cart/get", {}, function(cart){
            $("#order-popup").html(cart.html.popup_cart);
            $("#minicart").html(cart.html.minicart);
            $.magnificPopup.open({
                items: {
                    src: '#order-popup'
                },
                type: 'inline'
            }, 0);
        }, 'json');

        // $("#order-popup").load("/cart/get", {}, function(cart){
        //     $.magnificPopup.open({
        //         items: {
        //             src: '#order-popup'
        //         },
        //         type: 'inline'
        //     }, 0);
        // });
    });

    /**
     * Кнопка уменьшения колличества товара в корзине
     */
    $('#order-popup, #order_cart_content').on('click', '.cart_minus', function () {
        var $input = $(this).parent().find('input');
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
    });

    /**
     * Кнопка увеличения колличества товара в корзине
     */
    $('#order-popup, #order_cart_content').on('click', '.cart_plus', function () {
        var $input = $(this).parent().find('input');
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        return false;
    });

    /**
     * Обработка оформления заказа
     */
    $('#order-checkout').on('submit', function(e){
        e.preventDefault();
        var form = $(this);
        var error_div = form.find('.error-message');

        $.ajax({
            url: '/order/create',
            type: 'post',
            data: $(this).serialize(),
            beforeSend: function(){
                $('.checkout-step__body').addClass('checkout-step__body_loader');
                $('.checkout-step__body_second .error-message').fadeOut(300, function(){
                    $('.checkout-step__body_second .error-message__text').html('');
                });
                $('select, input').removeClass('input-error');
            },
            success: function(response) {
                if (response.error) {
                    var html = '';
                    $.each(response.error, function (id, text){
                        var error = id.split('.');
                        $('[name="' + error[0] + '[' + error[1] + ']"').addClass('input-error');
                        html += text + '<br>';
                    });
                    $('.cart-block_checkout .error-message__text').html(html);
                    $('.cart-block_checkout').removeClass('checkout-step__body_loader');
                    $('.cart-block_checkout .error-message').fadeIn(300);
                } else if (response.success) {
                    if (typeof dataLayer !== 'undefined') {
                        dataLayer.push({'event':'checkout'});
                    }
                    if (response.success == 'liqpay') {
                        // $('body').prepend(
                        //     '<form method="POST" id="liqpay-form" action="' + response.liqpay.url + '" accept-charset="utf-8">' +
                        //     '<input type="hidden" name="data" value="' + response.liqpay.data + '" />' +
                        //     '<input type="hidden" name="signature" value="' + response.liqpay.signature + '" />' +
                        //     '</form>');
                        // $('#liqpay-form').submit();
                        LiqPayCheckout.init({
                            data: response.liqpay.data,
                            signature:  response.liqpay.signature,
                            embedTo: "#liqpay_checkout",
                            mode: "embed" // embed || popup
                        }).on("liqpay.callback", function(data){
                            console.log(data.status);
                            console.log(data);
                            window.location = '/checkout/complete?order_id=' + response.order_id;
                        }).on("liqpay.ready", function(data){
                            $('#liqpay_checkout').css('display', 'block');
                            $('.order-page__forms-wrapper').css('display', 'none');
                        }).on("liqpay.close", function(data){
                            window.location = '/checkout/complete?order_id=' + response.order_id;
                        });
                    } else if (response.success == 'redirect') {
                        if(typeof response.url === 'undefined'){
                            window.location = '/checkout/complete?order_id=' + response.order_id;
                        }else{
                            window.location = response.url;
                        }
                    }
                }
            }
        })
    });

    $('#checkout-delivery-payment').on('change', '#checkout-step__payment', function(){
        if($(this).val() == 'instant_installments' || $(this).val() == 'payment_in_parts'){
            $('#checkout-payment__parts').parent().removeClass('hidden');
        }else{
            $('#checkout-payment__parts').parent().addClass('hidden');
        }
    });

    $('.subscribe-form').on('submit', function(e){
        e.preventDefault();

        $.ajax({
            url: '/subscribe',
            data: $(this).serialize(),
            method: 'post',
            dataType: 'json',
            success: function(response){
                if (response.email){
                    swal('Подписка', response.email[0], 'error');
                } else if (response.success) {
                    swal('Подписка', response.success, 'success');
                }

                $('.subscribe-form').find('input[type="email"]').val('');
            }
        });
    });

    /*табы логин и регистрация*/
    $(function() {
        $('ul.log_reg_caption').on('click', 'li:not(.active)', function() {
            $(this)
                .addClass('active').siblings().removeClass('active')
                .closest('nav.log_reg_tabs').find('div.log_reg_content').removeClass('active').eq($(this).index()).addClass('active');
        });

    });

    $('.catalog-wrapper').on('click', '.filter-title__wrapper', function(){
        $(this).parent().toggleClass('active');
    });

    $('.consult-form, .contact-form').on('sent', function(){
        if (typeof dataLayer !== 'undefined') {
            dataLayer.push({'event':'get_help'});
        }
    });

    $('#price-popup form').on('sent', function(){
        if (typeof dataLayer !== 'undefined') {
            dataLayer.push({'event':'get_price'});
        }
    });

    $('#quick-order-popup form').on('sent', function(){
        if (typeof dataLayer !== 'undefined') {
            dataLayer.push({'event':'checkout'});
        }
    });

    $('#close_reminder').click(function(){
        $('#reminder').hide();
        $.post('/hide_reminder', [], function(){});
    });

    $('.add_to_cart_btn').click(function(){
        var id = $(this).data('id');
        $.magnificPopup.open({
            items: {
                src: '/product_popup/'+id
            },
            type: 'ajax',
            callbacks: {
                ajaxContentAdded: function(){
                    $('.mfp-content .variation-select, .mfp-content .result-price .count_field').change(function(){
                        var result_price = parseFloat($('.mfp-content .product-price').data('price'));
                        var hash = '';
                        var attrs = [];
                        $('.mfp-content .variation-select').each(function(){
                            var val = $(this).val();
                            if(val != ''){
                                attrs.push(val);
                            }
                        });
                        hash = attrs.sort().join('_');

                        $('.mfp-content [name="variation"]').prop('checked', false);
                        var input = $('#var_'+hash);
                        if(hash != '' && input.length){
                            input.prop('checked', true);
                            var price = parseFloat(input.data('price'));
                            $('.mfp-content .product-price').html(price + ' грн.');
                            var result_price = price * parseInt($('.mfp-content .result-price .count_field').val());
                            $('.mfp-content .result-product-price').html(result_price + ' грн.');
                            $('.mfp-content .result-product-price-wrapper').show();
                        }else{
                            if($('.mfp-content .variation-select').length == 0){
                                var price = parseFloat($('.mfp-content .product-price').data('price'));
                                var result_price = price * parseInt($('.mfp-content .result-price .count_field').val());
                                $('.mfp-content .result-product-price').html(result_price + ' грн.');
                                $('.mfp-content .result-product-price-wrapper').show();
                            }else{
                                $('.mfp-content .product-price').html($('.mfp-content .product-price').data('price') + ' грн.');
                                $('.mfp-content .result-product-price-wrapper').hide();
                                if($(this).hasClass('variation-select')){
                                    flushNextSelects($(this));
                                    $('.mfp-content .result-price .count_field').change();
                                }
                            }
                        }
                        hideVariationOptionsPopup();
                    });

                    $('.mfp-content .btn_buy').click(function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        var $this = $(this);
                        var qty = $('.mfp-content .result-price .count_field').val();
                        var data = {
                            action: 'add',
                            product_id: $this.data('prod-id'),
                            quantity: qty > 1 ? qty : 1
                        };

                        var variation = $('.mfp-content [name="variation"]:checked');
                        if(variation.length){
                            data['variation'] = variation.val();
                        }

                        $.post("/cart/update", data, function(cart){
                            $("#order-popup").html(cart.html.popup_cart);
                            $("#minicart").html(cart.html.minicart);
                            $.magnificPopup.close();
                            $.magnificPopup.open({
                                items: {
                                    src: '#order-popup'
                                },
                                type: 'inline'
                            }, 0);
                            update_cart_quantity();

                            if(typeof fbq !== 'undefined' && typeof fbqProductsData[data.product_id] !== 'undefined'){
                                fbq('track', 'AddToCart', fbqProductsData[data.product_id]);
                            }
                        }, 'json');

                        // $("#order-popup").load("/cart/update", data, function(cart){
                        //     $.magnificPopup.close();
                        //     $.magnificPopup.open({
                        //         items: {
                        //             src: '#order-popup'
                        //         },
                        //         type: 'inline'
                        //     }, 0);
                        //     update_cart_quantity();
                        //
                        //     if(typeof fbq !== 'undefined' && typeof fbqProductsData[data.product_id] !== 'undefined'){
                        //         fbq('track', 'AddToCart', fbqProductsData[data.product_id]);
                        //     }
                        // });
                    });

                    $('.mfp-content .popup-btn').click(function(){
                        $.magnificPopup.close();
                        $.magnificPopup.open({
                            items: {
                                src: '#quick-order-popup'
                            },
                            type: 'inline'
                        }, 0);
                    });

                    /**
                     * Кнопка уменьшения колличества товара в корзине
                     */
                    $('.mfp-content').on('click', '.cart_minus', function () {
                        var $input = $(this).parent().find('input');
                        var count = parseInt($input.val()) - 1;
                        count = count < 1 ? 1 : count;
                        $input.val(count);
                        $input.change();
                        return false;
                    });

                    /**
                     * Кнопка увеличения колличества товара в корзине
                     */
                    $('.mfp-content').on('click', '.cart_plus', function () {
                        var $input = $(this).parent().find('input');
                        $input.val(parseInt($input.val()) + 1);
                        $input.change();
                        return false;
                    });

                    $('.mfp-content .product-slider').not('.slick-initialized').slick({
                        speed: 700,
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: false,
                        arrows: true,
                        nextArrow: '<div class="arrow-right"></div>',
                        prevArrow: '<div class="arrow-left"></div>',
                        asNavFor: '.mfp-content .product-nav'
                    }).on('lazyLoaded', function (event, slick, image, imageSource) {
                        var picture = $(image[0]).parents('picture');
                        if (picture.length) {
                            picture
                                .children('source')
                                .each(function (index, el) {
                                    var $child = $(el),
                                        source = $child.data('lazy');

                                    if (source) {
                                        $child.attr('srcset', source);
                                    }
                                });
                        }
                    });

                    $('.mfp-content .product-nav').not('.slick-initialized').slick({
                        speed: 700,
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        infinite: false,
                        arrows: false,
                        focusOnSelect: true,
                        asNavFor: '.mfp-content .product-slider',
                        responsive: [
                            {
                                breakpoint: 480,
                                settings: {
                                    slidesToShow: 2,
                                    vertical: true
                                }
                            }
                        ]
                    }).on('lazyLoaded', function (event, slick, image, imageSource) {
                        var picture = $(image[0]).parents('picture');
                        if (picture.length) {
                            picture
                                .children('source')
                                .each(function (index, el) {
                                    var $child = $(el),
                                        source = $child.data('lazy');

                                    if (source) {
                                        $child.attr('srcset', source);
                                    }
                                });
                        }
                    });
                }
            }
        }, 0);
    });

    function hideVariationOptionsPopup(){
        var variations = [];
        var current_select;
        $('.mfp-content [name="variation"]').each(function(){
            variations.push($(this).attr('id').replace('var_', ''));
        });
        var selects = $('.mfp-content .variation-select');
        var attrs = [];
        if(selects.length > 1){
            if(selects.eq(0).val() !== '')
                attrs.push(selects.eq(0).val());

            for(var i=1; i<selects.length; i++){
                current_select = selects.eq(i);
                current_select.find('option').each(function(){
                    var opt_var = clearVariations(variations, attrs, $(this).val());
                    if(opt_var.length == 0){
                        $(this).attr('disabled', 'disabled').css('display', 'none');
                        if(current_select.val() == $(this).val()){
                            current_select.find('option:first-child').prop('selected', true);
                        }
                    }else{
                        $(this).prop('disabled', false).css('display', 'block');
                    }
                });
                if(selects.eq(i).val() !== ''){
                    attrs.push(selects.eq(i).val());
                }
            }
        }
    }
});

/**
 * Обновление корзины
 * @param data
 */
function update_cart(data){
    $.post("/cart/update", data, function(cart){
        $("#order-popup").html(cart.html.popup_cart);
        $("#minicart").html(cart.html.minicart);
        var order_cart_content = $('#order_cart_content');
        if(order_cart_content.length > 0){
            order_cart_content.html(cart.html.order_cart);
        }

        update_cart_quantity();
    }, 'json');

    // $("#order-popup").load("/cart/update", data, function(cart){
    //     var order_cart_content = $('#order_cart_content');
    //     if(order_cart_content.length > 0){
    //         order_cart_content.load("/cart/update", {type: "order_cart"});
    //     }
    //
    //     update_cart_quantity();
    // });
}

function update_cart_quantity() {
    var quantity = parseInt($('.order-popup__count-items').text());
    if(quantity > 0){
        if($('.login-inner .cart-wrapper i').length){
            $('.login-inner .cart-wrapper i').text(quantity);
        }else{
            $('.login-inner .cart-wrapper').append('<i>'+quantity+'</i>');
        }
    }else{
        $('.login-inner .cart-wrapper i').remove();
    }
    var sum = $('.order-popup__sum').text();
    if(typeof sum !== 'undefined'){
        $('.cart-wrapper__sum').text(sum);
    }else{
        $('.order-popup__sum').text('');
    }
}

/**
 * Загрузка городов и отделений Новой Почты
 * @param id
 * @param value
 */
window.newpostUpdate = function(id, value) {
    if (id == 'city') {
        var data = {
            city_id: value
        };
        var path = '/checkout/warehouses';
        var selector = jQuery('#checkout-step__warehouse');
    } else if (id == 'region') {
        var data = {
            region_id: value
        };
        var path = 'checkout/cities';
        var selector = jQuery('#checkout-step__city');
    }

    jQuery.ajax({
        url: path,
        data: data,
        type: 'post',
        dataType: 'json',
        beforeSend: function() {
            jQuery('.checkout-step__body_second .error-message').fadeOut(300);
            jQuery('.checkout-step__body').addClass('checkout-step__body_loader');
            jQuery('.checkout-step__body_second .error-message__text').html('');
            jQuery('#checkout-step__warehouse').html('<option value="0">Сначала выберите город!</option>');
            jQuery('#checkout-step__warehouse').trigger('refresh');
        },
        success: function(response){
            if (response.error) {
                jQuery('.checkout-step__body_second .error-message__text').html(response.error);
                jQuery('.checkout-step__body').removeClass('checkout-step__body_loader');
                jQuery('.checkout-step__body_second .error-message').fadeIn(300);
            } else if (response.success) {
                var html = '<option value="0">Выберите город</option>';
                jQuery.each(response.success, function(i, resp){
                    if (id == 'city') {
                        var info = resp.address_ru;
                    } else if (id == 'region') {
                        var info = resp.name_ru;
                    }
                    html += '<option value="' + resp.id + '">' + info + '</option>';
                });
                selector.html(html);
                selector.trigger('update.fs');
                jQuery('.checkout-step__body').removeClass('checkout-step__body_loader');
            }
        }
    })
};