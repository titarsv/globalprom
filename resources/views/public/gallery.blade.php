@extends('public.layouts.main')
@section('meta')
    <title>{!! $content->meta_title !!}</title>
    <meta name="description" content="{!! $content->meta_description !!}">
    <meta name="keywords" content="{!! $content->meta_keywords !!}">
    @if(!empty($content->robots))
        <meta name="robots" content="{!! $content->robots !!}">
    @endif
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
    {!! Breadcrumbs::render('html', $content) !!}
@endsection

@section('content')
    <main class="main-wrapper">
        <div class="inner-page__wrapper">
            <div class="container">
                <div class="col-xs-12"><span class="inner-page__title">Отгрузки</span></div>
            </div>
        </div>

        <section class="shipments-wrapper">
            <div class="container">
                <nav class="shipments-tabs">
                    <ul class="shipments-list">
                        <li class="shipments-list__item active">
                            <div class="shipments-list__item-inner">Все Фото</div>
                        </li>
                        @foreach($cats as $cat => $photos)
                            <li class="shipments-list__item">
                                <div class="shipments-list__item-inner">{{ $cat }}</div>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>

            <section class="shipments-content__wrapper active">
                <div class="container">
                    <ul class="shipments-content">
                        @foreach($all as $name => $photo)
                            <li class="shipments-block popup-btn col-md-4 col-xs-6" data-id="" data-mfp-src="{{ $photo }}" data-type="image" data-title="{{ $name }}">
                                <div class="shipments-pic__wrapper"><img alt="" class="shipments-pic" src="{{ $photo }}" /></div>
                                <div class="shipments-title__wrapper"><span class="shipments-title">{{ $name }}</span></div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                @if(count($all) > 6)
                    <div class="shipments-btn-more__wrapper">
                        <div class="shipments-btn-more__inner"><span class="shipments-btn-more">Посмотреть еще +</span></div>
                    </div>
                @endif
            </section>

            @foreach($cats as $cat => $photos)
                <section class="shipments-content__wrapper">
                    <div class="container">
                        <ul class="shipments-content">
                            @foreach($photos as $name => $photo)
                                <li class="shipments-block popup-btn col-md-4 col-xs-6" data-id="" data-mfp-src="{{ $photo }}" data-type="image" data-title="{{ $name }}">
                                    <div class="shipments-pic__wrapper"><img alt="" class="shipments-pic" src="{{ $photo }}" /></div>
                                    <div class="shipments-title__wrapper"><span class="shipments-title">{{ $name }}</span></div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @if(count($photos) > 6)
                    <div class="shipments-btn-more__wrapper">
                        <div class="shipments-btn-more__inner"><span class="shipments-btn-more">Посмотреть еще +</span></div>
                    </div>
                    @endif
                </section>
            @endforeach
        </section>
    </main>
@endsection