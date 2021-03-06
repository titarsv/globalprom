@extends('public.layouts.main')
@section('meta')
    <title>Новости</title>
    <meta name="description" content="{!! $settings->meta_description !!}">
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
    {!! Breadcrumbs::render('news') !!}
@endsection

@section('content')
    <main class="main-wrapper">
        <section class="siteSection">
            <div class="container">
                <h1>Новости</h1>
                @if($articles->count())
                    <div class="row">
                        <div class="col-md-12">
                            <div class="newsList-item newsList-item--big">
                                <div class="newsList-img">
                                    <img src="{!! $articles->first()->image->url('blog_list') !!}">
                                </div>
                                <div class="newsList-content">
                                    <div class="newsList-title">
                                        <a href="{{env('APP_URL')}}/news/{!! $articles->first()->url_alias !!}">{!! $articles->first()->title !!}</a>
                                    </div>
                                    <div class="newsList-text">
                                        {!! $articles->first()->subtitle !!}
                                    </div>
                                    <div class="newsList-meta clearfix">
                                        <div class="newsList-date">
                                            {!! $articles->first()->date !!}
                                        </div>
                                        <div class="newsList-action">
                                            <a href="{{env('APP_URL')}}/news/{!! $articles->first()->url_alias !!}" class="btn btn-primary">Читать дальше</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($articles->count() > 1)
                    <div class="row">
                        @foreach($articles as $i => $article)
                            @if($i && $i < 4)
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="newsList-item clearfix">
                                        <div class="newsList-img">
                                            <a href="{{env('APP_URL')}}/news/{!!$article->url_alias !!}"><img src="{!! $article->image->url('blog_list') !!}"></a>
                                        </div>
                                        <div class="newsList-content">
                                            <div class="newsList-title">
                                                <a href="{{env('APP_URL')}}/news/{!! $article->url_alias !!}">{!! $article->title !!}</a>
                                            </div>
                                            <div class="newsList-text">
                                                {!! $article->subtitle !!}
                                            </div>
                                        </div>
                                        <div class="newsList-meta clearfix">
                                            <div class="newsList-date">
                                                {!! $article->date !!}
                                            </div>
                                            <div class="newsList-action">
                                                <a href="{{env('APP_URL')}}/news/{!! $article->url_alias !!}" class="btn btn-primary">Читать далее</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
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
                            <div class="col-md-4">
                                <div class="newsList-item clearfix">
                                    <div class="newsList-img">
                                        <a href="{{env('APP_URL')}}/news/{!! $article->url_alias !!}"><img src="{!! $article->image->url('blog_list') !!}"></a>
                                    </div>
                                    <div class="newsList-content">
                                        <div class="newsList-title">
                                            <a href="{{env('APP_URL')}}/news/{!! $article->url_alias !!}">{!! $article->title !!}</a>
                                        </div>
                                        <div class="newsList-text">
                                            {!! $article->subtitle !!}
                                        </div>
                                    </div>
                                    <div class="newsList-meta clearfix">
                                        <div class="newsList-date">
                                            {!! $article->date !!}
                                        </div>
                                        <div class="newsList-action">
                                            <a href="{{env('APP_URL')}}/news/{!! $article->url_alias !!}" class="btn btn-primary">Читать далее</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    {{--<div class="more-items"><i></i>Загрузить еще</div>--}}
                    </div>
                </div>
            </section>
        @endif
    </main>
@endsection