'use strict';

var $ = require('jquery');
require('magnific-popup');
require('../../../../node_modules/magnific-popup/src/css/main.scss');
require('slick-carousel');
require('../../../../node_modules/slick-carousel/slick/slick.scss');

module.exports = function() {
  $('.popup-btn').each(function(index, obj) {
    var $this = $(obj);

    var settings = {};

    settings.type = 'inline';
    if ($this.data('type') !== '') {
      settings.type = $this.data('type');
    }

    if (settings.type == 'inline') {
      var slider = $($this.data('mfp-src')).find('.slick-slider');

      if (slider.length) {
        settings.callbacks = {
          open: function() {
            slider.slick();
          }
        };
      }
    }else if(settings.type == 'ajax'){
        settings.callbacks = {
            open: function() {
                window.galleryInterval = setInterval(function(){
                    var slider = $('.view_popup_prod-slider');
                    if(slider.length){
                        clearInterval(window.galleryInterval);
                        var number = slider.data('index');
                        slider.slick({
                            speed: 700,
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            infinite: false,
                            arrows: true,
                            nextArrow: '<div class="arrow-right"></div>',
                            prevArrow: '<div class="arrow-left"></div>',
                            asNavFor: '.product-nav'
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
                        }).slick('slickGoTo', number);
                    }
                }, 100);
            }
        };
    }

    $this.magnificPopup(settings);
  });
};
