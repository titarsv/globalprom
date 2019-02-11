@extends('public.layouts.main')
@section('meta')
    <title>Блог компании &quot;GlobalProm&quot; | Все о промышленном и грузоподъемном оборудовании</title>
    <meta name="description"  content="Узнайте первым: Блог компании &quot;GlobalProm&quot; на блоге компании &quot;GlobalProm&quot;" />
    <meta name="keywords" content="{!! $settings->meta_keywords !!}">
    <!-- Код тега ремаркетинга Google -->
    <script type="text/javascript">
        var google_tag_params = {
            dynx_itemid: '',
            dynx_pagetype: 'other',
            dynx_totalvalue: '',
        };
    </script>
    <script type="text/javascript">
        /* <![CDATA[ */
        var google_conversion_id = 765411960;
        var google_custom_params = window.google_tag_params;
        var google_remarketing_only = true;
        /* ]]> */
    </script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
@endsection

@section('breadcrumbs')
    {!! Breadcrumbs::render('blog') !!}
@endsection

@section('content')

    <main class="main-wrapper">
        <section class="siteSection">
            <div class="container">
                <h1>Статьи</h1>
                <div class="subHeader">Все о промышленном и грузоподъемном оборудовании</div>
                <nav class="newsTabs js-tabs">
                    <ul>
                        <li{{ empty($category) ? ' class=newsTabs-active' : '' }}>
                            <a href="{{env('APP_URL')}}/articles" class="btn">Все статьи</a>
                        </li>
                        <li{{ $category == "Календарь событий" ? ' class=newsTabs-active' : '' }}>
                            <a href="{{env('APP_URL')}}/articles/Календарь событий" class="btn">Календарь событий</a>
                        </li>
                        <li{{ $category == "Обзоры промооборудования" ? ' class=newsTabs-active' : '' }}>
                            <a href="{{env('APP_URL')}}/articles/Обзоры промооборудования" class="btn">Обзоры промооборудования</a>
                        </li>
                        <li{{ $category == "Как это сделать" ? ' class=newsTabs-active' : '' }}>
                            <a href="{{env('APP_URL')}}/articles/Как это сделать" class="btn">Как это сделать?</a>
                        </li>
                        <li{{ $category == "Советы экспертов" ? ' class=newsTabs-active' : '' }}>
                            <a href="{{env('APP_URL')}}/articles/Советы экспертов" class="btn">Советы экспертов</a>
                        </li>
                    </ul>
                    @if($articles !== null)
                        <div class="newsTabs-content active">
                            @if($articles->count())
                            <div class="col-md-6">
                                <div class="article-item article-item_big clearfix">
                                    <div class="article-item-img">
                                        <a href="{{env('APP_URL')}}/article/{!! $articles->first()->url_alias !!}"><img src="{!! $articles->first()->image->url('blog_list') !!}"></a>
                                    </div>
                                    <div class="article-item-content">
                                        <div class="article-item-title">
                                            <a href="{{env('APP_URL')}}/article/{!! $articles->first()->url_alias !!}">{!! $articles->first()->title !!}</a>
                                        </div>
                                        <div class="article-item-text">
                                            {!! $articles->first()->subtitle !!}
                                        </div>
                                    </div>
                                    <div class="article-item-meta clearfix">
                                        <div class="article-item-date">
                                            {!! $articles->first()->date !!}
                                        </div>
                                        <div class="article-item-action">
                                            <a href="{{env('APP_URL')}}/article/{!! $articles->first()->url_alias !!}">Читать далее</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($articles->count() > 1)
                            <div class="col-md-6">
                                @foreach($articles as $i => $article)
                                    @if($i && $i < 4)
                                        <div class="article-item clearfix">
                                            <div class="article-item-img">
                                                <a href="{{env('APP_URL')}}/articles/{!! $article->url_alias !!}"><img src="{!! $article->image->url('blog_list') !!}"></a>
                                            </div>
                                            <div class="article-item-content">
                                                <div class="article-item-title">
                                                    <a href="{{env('APP_URL')}}/articles/{!! $article->url_alias !!}">{!! $article->title !!}</a>
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
                                                    <a href="{{env('APP_URL')}}/articles/{!! $article->url_alias !!}">Читать далее</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            @endif
                        </div>
                    @else
                        <div class="subHeader">Нет добавленных статей</div>
                    @endif
                </nav>
            </div>
        </section>
        <section class="siteSection siteSection--gray">
            <div class="container">
                <div class="col-md-7 col-sm-12">
                    <div class="subscribe-title">
                        Подпишись на рассылку новостей
                    </div>
                    <div class="subscribe-text">
                        Подписывайтесь и получайте порцию новостей и событий в промышленной сфере. Не рассылаем СПАМ и не передаем данные третьим лицам.
                    </div>
                    <div class="subscribe-form-item form-inline">
                        <form class="subscribe-form" action="/sendmail">
                            {!! csrf_field() !!}
                            <input name="email" type="email" class="form-control" placeholder="Введите почту">
                            <button type="submit">Подписаться</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-5 col-sm-12">
                    <div class="subscribe-img">
                        <img src="../../images/letter.png">
                    </div>
                </div>
            </div>
        </section>

        @if($articles->count() > 4)
        <section class="siteSection">
            <div class="container">
                <div class="row">
                @foreach($articles as $i => $article)
                    @if($i > 3)
                        @if(($i - 1) % 3 == 0)
                            </div><div class="row">
                        @endif
                        <div class="col-md-6">
                            <div class="article-item clearfix">
                                <div class="article-item-img">
                                    <a href="{{env('APP_URL')}}/articles/{!! $article->url_alias !!}"><img src="{!! $article->image->url('blog_list') !!}"></a>
                                </div>
                                <div class="article-item-content">
                                    <div class="article-item-title">
                                        <a href="{{env('APP_URL')}}/articles/{!! $article->url_alias !!}">{!! $article->title !!}</a>
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
                                        <a href="{{env('APP_URL')}}/articles/{!! $article->url_alias !!}">Читать далее</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                </div>
            </div>
        </section>
        @endif
    </main>
@endsection