@extends('public.layouts.main')
@section('meta')
    <title>Поиск: {{ $search_text }}</title>
    <meta name="description" content="Поиск по запросу: {{ $search_text }}">
    <meta name="keywords" content="{{ $search_text }}">
    <!-- Код тега ремаркетинга Google -->
    <script type="text/javascript">
        var google_tag_params = {
            dynx_itemid: [{{ implode(', ', $products->pluck('id')->toArray()) }}],
            dynx_pagetype: 'searchresults',
            dynx_totalvalue: [{{ implode(', ', $products->pluck('price')->toArray()) }}],
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
    {!! Breadcrumbs::render('search') !!}
@endsection

@section('content')
    <main class="main-wrapper">
        <section class="siteSection">
            <div class="container">
                <h1>Поиск: {{ $search_text }}</h1>
                <div class="row">
                    <div class="col-sm-12">
                        <section class="cards">
                            @forelse($products as $product)
                                @include('public.layouts.product', $product)
                            @empty
                                <article class="order">
                                    <h5 class="order__title">В этой категории пока нет товаров!</h5>
                                </article>
                            @endforelse

                        </section>
                    </div>

                    <div class="col-sm-12">
                        {{--{!! $products->appends(['text' => $search_text])->render() !!}--}}
                        @include('public.layouts.pagination', ['paginator' => $paginator])
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection