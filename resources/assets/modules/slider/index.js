'use strict';

var $ = require('jquery');
require('slick-carousel');
require('../../../../node_modules/slick-carousel/slick/slick.scss');

module.exports = function() {
  $('.slick-slider').each(function() {
    var $this = $(this);
    if ($this.parents('.hidden').length == 0) {
      $this.slick();
    }
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
};
