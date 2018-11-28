@extends('public.layouts.main')

@section('breadcrumbs')
    {!! Breadcrumbs::render('history') !!}
@endsection

@section('content')
    <section class="siteSection">
        <div class="container">
            <h1>История заказов</h1>
        </div>
        <nav class="user-room__tabs">
            <ul class="user-room__tabs-list container">
                <li class="user-room__tabs-item"><a href="/user">Личные данные</a></li>
                <li class="user-room__tabs-item active"><a href="/user/history">История заказов</a></li>
            </ul>
        </nav>
    <div class="user-room__tabs-content container active">
        @if(count($orders))
        <ul class="user-room__order-history">
            @foreach($orders as $order)
            <li class="user-room__order-history-items row">
                <div class="user-room__order-history-wrapper">
                    <ul class="user-room__order-history-list">
                        @foreach($order->getProducts() as $product)
                            @if(!is_null($product['product']))
                                <li class="user-room__order-history-item">
                                    <div class="user-room__order-history-pic__wrapper">
                                        <a href="/product/{{ $product['product']->url_alias }}">
                                            <img class="user-room__order-history-pic" src="{{ $product['product']->image->url('product_list') }}" alt="">
                                        </a>
                                    </div>
                                    <div class="user-room__order-history-info">
                                        <a class="user-room__order-history-name" href="">{{ $product['product']->name }}</a>
                                    </div>
                                    <div class="user-room__order-history-buy">
                                        <span class="user-room__order-history-vol">{{ $product['product']->capacity }} x {{ $product['quantity'] }} шт.</span>
                                        <div class="user-room__order-history-price">
                                            <span class="user-room__order-history-uah">{{ $product['price'] }}  грн</span>
                                        </div>
                                    </div>
                                </li>
                            @else
                                <li class="user-room__order-history-item">
                                    <div class="user-room__order-history-info">
                                        <p>Товар более недоступен...</p>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    <div class="user-room__order-history-totals">
                        <span class="user-room__order-history-totals__title">Итого {{ $order->total_quantity}} товар(ов) на сумму:</span>
                        <div class="user-room__order-history-totals__price">
                            <span class="user-room__order-history-totals__uah">{{ $order->total_price }} грн</span>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        @else
        <div class="user-room__order-history__empty">Ваша история заказов пуста</div>
        @endif
    </div>
    </section>
@endsection