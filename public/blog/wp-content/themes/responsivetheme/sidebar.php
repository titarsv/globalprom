<div class="col-sm-4">
    <?php if ( is_active_sidebar( 'true_side' ) ) : ?>
        <?php if(is_single()):?>
            <div id="post-author" class="widget">
                <div id="article-author">
                    <div id="author-image"><?php $author_email = get_the_author_email(); echo get_avatar($author_email,'150');?></div>
                    <p class="author"><?php the_author_meta('user_firstname')?> <?php the_author_meta('user_lastname')?></p>
                    <p class="author-describe"><?php the_author_description();?></p>
                    <p id="write-author"><button class="btn btn-primary btn-sm no-radius popup-btn" data-mfp-src="#author-popup">Связаться с автором</button></p>
                </div>
            </div>

            <div class="mfp-hide">
                <div id='author-popup' class="order-popup" style="width: 480px; max-width: 100%;">
                    <strong class="popup-title">Связаться с автором</strong>
                    <form action="/sendmail" class="pbz_form clear-styles"
                          data-error-title="Ошибка отправки!"
                          data-error-message="Попробуйте отправить заявку через некоторое время."
                          data-success-title="Сообщение отправлено!"
                          data-success-message="Автор свяжется с Вами в ближайшее время.">
                        <input type="hidden" name="author" data-title="Автор" value="<?php the_author_meta('user_firstname')?> <?php the_author_meta('user_lastname')?>">
                        <input type="text" class="popup__input" name="first_name" placeholder="Введите имя" data-title="Имя" data-validate-required="Обязательное поле">
                        <input type="email" class="popup__input" name="email" placeholder="Введите email" data-title="Email" data-validate-required="Обязательное поле" data-validate-email="Email">
                        <textarea class="order-page__form-textarea" name="message" data-title="Сообщение" placeholder="Сообщение"></textarea>
                        <button type="submit" class="product-order__btn" style="margin: 0 auto;">Отправить</button>
                    </form>
                    <button title="Close (Esc)" type="button" class="mfp-close">×</button>
                </div>
            </div>
        <?php endif;?>
    <?php endif; ?>
    <div class="subscribe-wiget">
        <div class="subscribe-title">
            Подпишись на рассылку новостей
        </div>
        <div class="subscribe-text">
            Подписывайтесь и получайте порцию новостей и событий в промышленной сфере. <b>Не рассылаем
                СПАМ и не передаем данные третьим лицам.</b>
        </div>
        <div class="subscribe-form-item form-inline">
            <form action="/sendmail" class="subscribe-form">
                <input type="email" name="email" class="form-control" placeholder="Введите почту" data-validate-required="Обязательное поле">
                <button type="submit">Подписаться</button>
            </form>
        </div>

        <div class="subscribe-img">
            <img src="/images/letter.png">
        </div>
    </div>

    <?php dynamic_sidebar( 'true_side' ); ?>
</div>