@extends('public.layouts.main')
@section('meta')
    <title>
        @if(empty($category->meta_title) && empty($category['meta_title']))
            {!! $category->name !!} купить по выгодной цене в компании GlobalProm
        @else
            {!! $category->meta_title or $category['meta_title'] !!}
        @endif
        @if($paginator->currentPage() > 1) - cтраница {!! $paginator->currentPage() !!}@endif
    </title>

    @if(empty($category->meta_description))
        <meta name="description" content="Купить {!! $category->name !!}} в Харькове, ☎ (057) 751-70-59. Заказать производственное оборудование в компании GlobalProm.">
    @else
        <meta name="description" content="{!! $category->meta_description or '' !!}">
    @endif

    <meta name="keywords" content="{!! $category->meta_keywords or '' !!}">
    @if(!empty($category->canonical) && empty($_GET['page']))
        <meta name="canonical" content="{!! $category->canonical !!}">
    @endif
    @if(!empty($category->robots))
        <meta name="robots" content="{!! $category->robots !!}">
    @endif
    @if($paginator->currentPage() > 1)
        <link rel="prev" href="{!! $paginator->previousPageUrl() !!}">
    @endif
    @if($paginator->currentPage() < $paginator->lastPage())
        <link rel="next" href="{!! $paginator->nextPageUrl() !!}">
    @endif
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
    {!! Breadcrumbs::render('categories', $category) !!}
@endsection

@section('content')
    <main class="main-wrapper">
        <div class="container">
            <div class="catalog-wrapper {{ $category->url_alias }}">
                @if($category->parent_id != 0 && !$attributes->isEmpty())
                    <aside class="sidebar col-md-3">
                    <form action="#" method="get" id="filters">
                        <div class="sidebar-inner">
                            <span class="sidebar-title">Фильтр по товарам</span>
                            <div class="sidebar-hiiden">
                                <button class="clear-filters">
                                    <span>+</span>
                                    <strong>Сбросить фильтры</strong>
                                </button>
                                {{--<div class="filter-block">--}}
                                    {{--<div class="filter-title__wrapper">--}}
                                        {{--<span class="filter-title">Цена:</span>--}}
                                    {{--</div>--}}
                                    {{--<div class="price-inputs">--}}
                                        {{--<div class="price-inputs__inner">--}}
                                            {{--<span>от</span>--}}
                                            {{--<input type="text" name="price_min" class="sliderValue val1" data-index="0" value="{{ isset($price[2]) ? $price[2] : $price[0] }}" />--}}
                                            {{--<span>до</span>--}}
                                            {{--<input type="text" name="price_max" class="sliderValue val2" data-index="1" value="{{ isset($price[3]) ? $price[3] : $price[1] }}" />--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="price-range" data-value="{{ isset($price[2]) ? $price[2] : $price[0] }};{{ isset($price[3]) ? $price[3] : $price[1] }}" data-max="{{ $price[1] }}" data-min="{{ $price[0] }}"></div>--}}
                                {{--</div>--}}

                                @if(!$attributes->isEmpty())
                                    @foreach($attributes as $key => $attribute)
                                        <div class="filter-block{{ isset($filter[$attribute->id]) ? ' active' : '' }}">
                                            <div class="filter-title__wrapper">
                                                <span class="filter-title">{{ $attribute->name }}:</span>
                                                {{--<i class="filter-info">?</i>--}}
                                            </div>
                                            <ul class="filters-list">
                                                @foreach($attribute->values as $i => $attribute_value)
                                                    @if(!empty($attribute_value->name))
                                                        <li class="filter">
                                                            <input type="checkbox"
                                                                   name="filter_attributes[{!! $attribute->id !!}][value][{!! $attribute_value->id !!}]"
                                                                   data-attribute="{{ $attribute->id }}"
                                                                   data-value="{{ $attribute_value->id }}"
                                                                   id="product-filter-{!! $key !!}__check-{!! $i !!}"
                                                                   class="filter-checkbox"
                                                            @if(isset($filter[$attribute->id]) && in_array($attribute_value->id, $filter[$attribute->id]))
                                                                   checked
                                                                    @endif>
                                                            <label for="product-filter-{!! $key !!}__check-{!! $i !!}">{!! $attribute_value->name !!}</label>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </form>
                </aside>
                    <div class="catalog col-md-9">
                @else
                    <div class="catalog col-md-12">
                @endif
                    <div class="row">
                        <h1 class="catalog-title">{!! $category->name or $category['name'] !!}</h1>
                        @if($category->hasChildren() && empty($filter))
                            <div class="subcategories">
                                @foreach($category->children()->where('status', 1)->get() as $subcat)
                                    <div class="item cat-item col-sm-4 col-xs-6">
                                        <div class="item-inner">
                                            <div class="item-pic__wrapper">
                                                @if(!empty($subcat->image))
                                                <a href="{{env('APP_URL')}}/categories/{{ $subcat->url_alias }}">
                                                    {!! $subcat->image->webp_image('product_list', ['alt' => $subcat->name, 'class' => 'item-pic']) !!}
                                                    {{--<img class="item-pic" src="{{ $subcat->image->url('product_list') }}" alt="">--}}
                                                </a>
                                                @endif
                                            </div>
                                            <div class="item-info__wrapper">
                                                <a class="item-link" href="{{env('APP_URL')}}/categories/{{ $subcat->url_alias }}">{{ $subcat->name }}</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="clearfix"></div>
                        @endif

                        <div class="cat-filters">
                            <form method="get" @if(!empty($category['url_alias']) && $category['url_alias'] == 'new') style="display:none" @endif>
                            <ul class="cat-view">
                                {{--<li class="cat-view__item grid active"><i></i></li>--}}
                                {{--<li class="cat-view__item list"><i></i></li>--}}
                            </ul>
                            <div class="cat-filter__dropdown-wrapper">
                                <select name="sorting" class="cat-filter__dropdown" onchange="sortBy(jQuery(this).val())">
                                    @foreach($sort_array as $sort)
                                        <option value="{!! $sort['value'] !!}" @if($sort['value'] == $current_sort) selected @endif>{!! $sort['name'] !!}</option>
                                    @endforeach
                                </select>
                            </div>
                            </form>
                        </div>
                        <div class="catalog-main">
                            @forelse($products as $product)
                                @include('public.layouts.product', ['product' => $product])
                            @empty
                                <article>
                                    <span>В этой категории пока нет товаров!</span>
                                </article>
                            @endforelse
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    @include('public.layouts.pagination', ['paginator' => $paginator])
                    {{--<div class="more-items"><i></i>Загрузить еще</div>--}}
                </div>
            </div>
        </div>
        @if(!empty($category->description) && $paginator->currentPage() == 1)
        <div class="catalog-description">
            <div class="container">
                {!! $category->description !!}
            </div>
        </div>
        @endif
    </main>
@endsection