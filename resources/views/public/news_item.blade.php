@extends('public.layouts.main')
@section('meta')
    <title>{!! $article->meta_title !!}</title>
    <meta name="description" content="{!! $article->meta_description !!}">
    <meta name="keywords" content="{!! $article->meta_keywords !!}">
    @if(!empty($article->robots))
        <meta name="robots" content="{!! $article->robots !!}">
    @endif
@endsection

@section('breadcrumbs')
    {!! Breadcrumbs::render('news_item', $article) !!}
@endsection

@section('content')
    <main class="main-wrapper">
        <div class="inner-page__wrapper">
            <div class="container">
                <div class="col-xs-12"><span class="inner-page__title">{!! $article->title !!}</span></div>
            </div>
        </div>
        <section class="news-unit__wrapper">
            <div class="container">
                <div class="news-unit__content col-xs-12">
                    <div class="news-unit__date">{!! $article->date !!}</div>
                    <div class="news-unit__pic-wrapper">
                        <img class="news-unit__pic" src="{!! $article->image->url('article') !!}" alt="">
                    </div>
                    {!! html_entity_decode($article->text) !!}

                    <p><b>За более детальной информацией о новинках обращайтесь к нашим специалистам по номерам телефона, указанным на сайте или через форму обратной связи в разделе «Контакты».</b></p>
                </div>
            </div>
        </section>
        <section class="news-unit__footer">
            <div class="container">
                <div class="news-unit__footer-inner">
                    <form action="/sendmail" class="news-unit-form subscribe-form">
                        <span class="news-unit-form__title">Подпишись на рассылку новостей</span>
                        <div class="news-unit-form__descr">
                            Подписывайтесь и получайте порцию новостей и событий в промышленной сфере.
                            <strong>Не рассылаем СПАМ и не передаем данные третьим лицам.</strong>
                        </div>
                        <div class="news-unit-form__composition">
                            {!! csrf_field() !!}
                            <input class="news-unit-form__input" type="text" name="email" placeholder="Ваш E-mail">
                            <button type="submit" class="news-unit-form__btn">Подписаться</button>
                        </div>
                    </form>
                    <img class="news-unit__footer-pic" src="../../images/letter.png" alt="">
                </div>
            </div>
        </section>
        @if($recommended !== 'null')
            <section class="siteSection">
                <div class="container">
                    @foreach($recommended as $i => $article)
                        <div class="col-md-6">
                            <div class="article-item clearfix">
                                <div class="article-item-img">
                                    <a href="{{env('APP_URL')}}/news/{!! $article->url_alias !!}"><img src="{!! $article->image->url('blog_list') !!}"></a>
                                </div>
                                <div class="article-item-content">
                                    <div class="article-item-title">
                                        <a href="{{env('APP_URL')}}/news/{!! $article->url_alias !!}">{!! $article->title !!}</a>
                                    </div>
                                    <div class="article-item-text">
                                        {!! $article->subtitle !!}
                                    </div>
                                </div>
                                <div class="article-item-meta clearfix">
                                    <div class="article-item-date">
                                        {!! $article->date !!}
                                    </div>
                                    <div class="article-item-action">
                                        <a href="{{env('APP_URL')}}/news/{!! $article->url_alias !!}">Читать далее</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </main>
@endsection