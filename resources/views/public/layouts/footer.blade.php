<footer class="main-footer">
    <div class="subscribe-footer">
        <div class="container">
            <div class="col-md-5 subscribe-txt__wrapper">
                <span class="subscribe-title">Только для подписчиков:</span>
                <span class="subscribe-txt">Горячие акции, закрытые распродажи и полезные советы</span>
            </div>
            <div class="col-md-7 subscribe-form__wrapper">
                <form action="/sendmail" class="subscribe-form">
                    {!! csrf_field() !!}
                    <div class="subscribe-form__composition">
                        <input class="subscribe-form__input" type="text" name="email" data-validate-required="Обязательное поле" placeholder="Ваш E-mail">
                        <button type="submit" class="subscribe-form__btn">Подписаться</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="links-footer">
        <div class="container">
            <div class="links-footer__wrapper">
                <ul class="footer-menu list4">
                    <li class="footer-menu__title">Контакты</li>
                    @if($source == 'google')
                        <li class="footer-menu__item">
                            <a class="footer-menu__link" href="tel:+380577517063">+38 (057) 751-70-63</a>
                        </li>
                        <li class="footer-menu__item">
                            <a class="footer-menu__link" href="tel:+380508706608">+38 (050) 870-66-08</a>
                        </li>
                        <li class="footer-menu__item">
                            <a class="footer-menu__link" href="tel:+380671627494">+38 (067) 162-74-94</a>
                        </li>
                        <li class="footer-menu__item">
                            <a class="footer-menu__link" href="mailto:office@globalprom.com.ua">office@globalprom.com.ua</a>
                        </li>
                    @elseif($source == 'yandex')
                        <li class="footer-menu__item">
                            <a class="footer-menu__link" href="tel:+380577517062">+38 (057) 751-70-62</a>
                        </li>
                        <li class="footer-menu__item">
                            <a class="footer-menu__link" href="tel:+380508706766">+38 (050) 870-67-66</a>
                        </li>
                        <li class="footer-menu__item">
                            <a class="footer-menu__link" href="tel:+380671627874">+38 (067) 162-78-74</a>
                        </li>
                        <li class="footer-menu__item">
                            <a class="footer-menu__link" href="mailto:office@globalprom.com.ua">office@globalprom.com.ua</a>
                        </li>
                    @elseif($source == 'facebook')
                        <li class="footer-menu__item">
                            <a class="footer-menu__link" href="tel:+380577517059">+38 (057) 751-70-59</a>
                        </li>
                        <li class="footer-menu__item">
                            <a class="footer-menu__link" href="tel:+380671860180">+38 (067) 186-01-80</a>
                        </li>
                        <li class="footer-menu__item">
                            <a class="footer-menu__link" href="tel:+380663583955">+38 (066) 358 39 55</a>
                        </li>
                    @else
                        <li class="footer-menu__item">
                            <a class="footer-menu__link" href="tel:+380577517059">+38 (057) 751-70-59</a>
                        </li>
                        <li class="footer-menu__item">
                            <a class="footer-menu__link" href="tel:+380506972161">+38 (050) 697-21-61</a>
                        </li>
                        <li class="footer-menu__item">
                            <a class="footer-menu__link" href="tel:+380973229908">+38 (097) 322-99-08</a>
                        </li>
                        <li class="footer-menu__item">
                            <a class="footer-menu__link" href="mailto:office@globalprom.com.ua">office@globalprom.com.ua</a>
                        </li>
                    @endif
                </ul>
                <span class="links-footer__sep-line"></span>
                <ul class="footer-menu list5">
                    <li class="footer-menu__title">Адреса</li>
                    <li class="footer-menu__item">
                        г. Киев, ул. Передовая 27
                    </li>
                    <li class="footer-menu__item">
                        Склад в Киеве: ул. Передовая 27
                    </li>
                    <li class="footer-menu__item">
                        г. Харьков, 61146 ул. Сумская 37
                    </li>
                    <li class="footer-menu__item">
                        Склад в Харькове: ул. Академика Павлова 271
                    </li>
                </ul>
                <span class="links-footer__sep-line"></span>
                <ul class="footer-menu list2">
                    <li class="footer-menu__title">Сотрудничество</li>
                    <li class="footer-menu__item">
                        <a class="footer-menu__link" href="{{env('APP_URL')}}/page/postavshhiki-i-partneri">Поставщики и Партнеры</a>
                    </li>
                    <li class="footer-menu__item">
                        <a class="footer-menu__link" href="{{env('APP_URL')}}/page/dilerskaja-set">Дилерская сеть</a>
                    </li>
                    <li class="footer-menu__item">
                        <a class="footer-menu__link" href="{{env('APP_URL')}}/page/sotrudnichestvo">Поиск поставщиков</a>
                    </li>
                    <li class="footer-menu__item">
                        <a class="footer-menu__link" href="{{env('APP_URL')}}/page/policy">Политика конфиденциальности</a>
                    </li>
                    <li class="footer-menu__item">
                        <a class="footer-menu__link" href="{{env('APP_URL')}}/page/dogovor-oferty">Договор оферты</a>
                    </li>
                </ul>
                <span class="links-footer__sep-line mid"></span>
                <ul class="footer-menu list3">
                    <li class="footer-menu__title">Важно</li>
                    <li class="footer-menu__item">
                        <a class="footer-menu__link" href="{{env('APP_URL')}}/blog">Полезные статьи</a>
                    </li>
                    <li class="footer-menu__item">
                        <a class="footer-menu__link" href="{{env('APP_URL')}}/page/uslugi">Дополнительные услуги</a>
                    </li>
                    <li class="footer-menu__item">
                        <a class="footer-menu__link" href="{{env('APP_URL')}}/page/voprosi-i-otveti">Вопросы и ответы (FAQ)</a>
                    </li>
                    <li class="footer-menu__item">
                        <a class="footer-menu__link" href="{{env('APP_URL')}}/page/gorjachie-vakansii-kompanii-ooo-npp-globalprom">Горячие вакансии «GlobalProm»</a>
                    </li>
                </ul>
                <span class="links-footer__sep-line last"></span>
                <div class="footer-socials">
                    <span class="footer-menu__title">Все новости в соц. сетях:</span>
                    <noindex>
                        <ul class="footer-socials__list">
                            <li class="footer-socials__item">
                                <a class="footer-socials__link fb" target="_blank" rel="nofollow" href="https://www.facebook.com/gglobalprom/"></a>
                            </li>
                            <li class="footer-socials__item">
                                <a class="footer-socials__link vk" target="_blank" rel="nofollow" href="https://vk.com/club132686471"></a>
                            </li>
                            <li class="footer-socials__item">
                                <a class="footer-socials__link li" target="_blank" rel="nofollow" href="https://www.linkedin.com/company-beta/15239152"></a>
                            </li>
                            {{--<li class="footer-socials__item">--}}
                            {{--<a class="footer-socials__link gp" target="_blank" rel="nofollow" href="https://plus.google.com/u/0/+GlobalpromUaKh"></a>--}}
                            {{--</li>--}}
                            <li class="footer-socials__item">
                                <a class="footer-socials__link ok" target="_blank" rel="nofollow" href="https://ok.ru/group/54392722292850"></a>
                            </li>
                            <li class="footer-socials__item">
                                <a class="footer-socials__link in" target="_blank" rel="nofollow" href="https://www.instagram.com/globalprom/"></a>
                            </li>
                            <li class="footer-socials__item">
                                <a class="footer-socials__link tw" target="_blank" rel="nofollow" href="https://twitter.com/globalprom"></a>
                            </li>
                            <li class="footer-socials__item">
                                <a class="footer-socials__link yt" target="_blank" rel="nofollow" href="https://www.youtube.com/channel/UCLet8R8Be22p-948IxqkvOg/featured"></a>
                            </li>
                        </ul>
                    </noindex>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-footer">
        <div class="container">
            <span class="copyright">ООО "НПП "ГлобалПром" © 2013-2019 Политика конфиденциальности</span>
            <img class="visa" src="/images/visa.png" alt="visa">
        </div>
    </div>
</footer>

<div class="container to-top__wrapper">
    <a href="#top" class="to-top">
        <i></i>
        <span>наверх</span>
    </a>
</div>


<div class="mfp-hide">
    <div id='order-popup' class="order-popup">
        <div class="order-popup__empty">
            Здесь пусто...
        </div>
        <button title="Close (Esc)" type="button" class="mfp-close">×</button>
    </div>

    <div id='price-popup' class="order-popup">
        <strong class="popup-title">Скачать каталог</strong>
        <span class="popup-info">Скачайте каталог с нашей<br> продукцией</span>
        <form action="/sendmail" class="pbz_form clear-styles"
              data-error-title="Ошибка отправки!"
              data-error-message="Попробуйте отправить заявку через некоторое время."
              data-success-title="Спасибо за заявку!"
              data-success-message="Наш менеджер свяжется с вами в ближайшее время.">
            <input type="tel" class="popup__input" name="phone" placeholder="Введите телефон" data-title="Телефон" data-validate-required="Обязательное поле" data-validate-phone="Неправильный номер">
            {{--<button type="submit" class="product-order__btn">Скачать каталог</button>--}}
            <a href="/catalog.pdf" download="catalog.pdf" target="_blank" id="catalog_link" class="product-order__btn">Скачать каталог</a>
        </form>
        <img src="/images/pdf.png" alt="pdf"/>
        <button title="Close (Esc)" type="button" class="mfp-close">×</button>
    </div>

    <div id='quick-order-popup' class="order-popup">
        <strong class="popup-title">Купить в один клик</strong>
        <span class="popup-info">Введите Ваш номер телефона<br> и наш менеджер свяжется с Вами в ближайшее время</span>
        <form action="/sendmail" class="pbz_form clear-styles"
              data-error-title="Ошибка отправки!"
              data-error-message="Попробуйте отправить заявку через некоторое время."
              data-success-title="Спасибо за заявку!"
              data-success-message="Наш менеджер свяжется с Вами в ближайшее время.">
            <input type="tel" class="popup__input" name="phone" placeholder="Введите телефон" data-title="Телефон" data-validate-required="Обязательное поле" data-validate-phone="Неправильный номер">
            <button type="submit" class="product-order__btn">Купить</button>
        </form>
        <button title="Close (Esc)" type="button" class="mfp-close">×</button>
    </div>
</div>

@if(strtotime($cart->updated_at) < time() - 720 && strpos('reminder_showed', $cart->user_data) === false && $cart->total_quantity > 0)
    <div id="reminder" style="position: fixed;bottom: 0;background-color: #fff;width: 100%;">
        <div class="container">
            <div class="row">
                <div class="logo-wrapper col-sm-3">
                    <picture>
                        <source srcset="{{env('APP_URL')}}/images/webp/logo.webp" type="image/webp">
                        <source srcset="{{env('APP_URL')}}/images/logo.png" type="image/png">
                        <img class="header-logo" src="{{env('APP_URL')}}/images/logo.png" alt="Грузоподъёмное и промышленное оборудование" title="Грузоподъёмное и промышленное оборудование">
                    </picture>
                </div>
                <div class="col-sm-offset-4 col-sm-3">
                    <p>Чтобы завершить заказ нажмите</p>
                </div>
                <div class="col-sm-2">
                    <a href="https://globalprom.com.ua/cart" class="consult-form__btn">Заказать</a>
                </div>
            </div>
        </div>
        <div id="close_reminder" style="position: absolute; top: 0; right: 0">x</div>
    </div>
@endif
