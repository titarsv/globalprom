<!-- Load Custom CSS Start -->
<script>loadCSS( "/assets/css/application.css", false, "all" );</script>
<!-- Load Custom CSS End -->

<!-- Optimized loading JS Start -->
{{--<script>var scr = {"scripts":[--}}
        {{--{"src" : "/assets/js/vendors.js", "async" : false},--}}
        {{--{"src" : "/app.js", "async" : false}--}}
    {{--]};!function(t,n,r){"use strict";var c=function(t){if("[object Array]"!==Object.prototype.toString.call(t))return!1;for(var r=0;r<t.length;r++){var c=n.createElement("script"),e=t[r];c.src=e.src,c.async=e.async,n.body.appendChild(c)}return!0};t.addEventListener?t.addEventListener("load",function(){c(r.scripts);},!1):t.attachEvent?t.attachEvent("onload",function(){c(r.scripts)}):t.onload=function(){c(r.scripts)}}(window,document,scr);--}}
{{--</script>--}}
<!-- Optimized loading JS End -->
<script src="/assets/js/vendors.js"></script>
<script src="/app.js"></script>

<script data-skip-moving="true">
    var bitrix_loaded = false;
    window.onscroll = function() {
        if(!bitrix_loaded){
            bitrix_loaded = true;
            (function(w,d,u){
                var s=d.createElement('script');s.async=1;s.src=u+'?'+(Date.now()/60000|0);
                var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
            })(window,document,'https://cdn.bitrix24.ua/b2989835/crm/site_button/loader_3_5u6ldr.js');
        }
    }
</script>

{{--<div class="mfp-hide exit-popup">
    <div id="exit-popup" class="photo-popup__wrapper">
        <p class="exit-popup__title">НЕ СПЕШИТЕ УХОДИТЬ!</p>
        <span class="exit-popup_subtitle">Задайте интересующий Вас вопрос нашим супер профессиональным менеджерам прямо сейчас</span>
        <form class="pbz_form clear-styles" data-error-title="Ошибка отправки!" data-error-message="Попробуйте отправить заявку через некоторое время." data-success-title="Спасибо за заявку!" data-success-message="Наш менеджер свяжется с вами в ближайшее время." action="/sendmail">
            <ul class="product-popup__form-fields">
                <li>
                    <input type="text" name="phone" class="product-popup__form-input" placeholder="Введите Ваш телефон" data-validate-required="Обязательное поле"
                           data-validate-uaphone="Неправильный номер" data-title="Телефон">
                </li>
                <li>
                    <button class="product-popup__form-btn">ЗАДАТЬ ВОПРОС</button>
                </li>
            </ul>
        </form>
        <button type="button" class="mfp-close close-btn">×</button>
    </div>
</div>
<div id="exit_cont"></div>--}}
<div class="mobile-fixed-phone">
    <a href="tel:+380506972161">позвонить</a>
</div>