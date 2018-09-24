@extends('public.layouts.main')

@section('meta')
    <title>Личные данные</title>
    <meta name="description" content="{!! $settings->meta_description !!}">
    <meta name="keywords" content="{!! $settings->meta_keywords !!}">
@endsection

@section('breadcrumbs')
    {!! Breadcrumbs::render('user') !!}
@endsection

@section('content')
    <section class="siteSection">
        <div class="container">
            <h1>Личные данные</h1>
        </div>
        <nav class="user-room__tabs">
            <ul class="user-room__tabs-list container">
                <li class="user-room__tabs-item active"><a href="/user">Личные данные</a></li>
                <li class="user-room__tabs-item"><a href="/user/history">История заказов</a></li>
            </ul>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-push-3 col-md-8 col-md-push-2 col-sm-10 col-sm-push-1">
                    <div class="row">
                        <div class="row user-room__form-row">
                            <div class="col-sm-6">
                                <label class="user-room__label" for="name">Ваше имя</label>
                                <input class="user-room__input" type="text" name="name" value="{{ $user->first_name ? $user->first_name : '' }}" disabled="">
                            </div>
                            <div class="col-sm-6">
                                <label class="user-room__label" for="last-name">Фамилия</label>
                                <input class="user-room__input" type="text" name="last-name" value="{{ $user->last_name ? $user->last_name : '' }}" disabled="">
                            </div>
                        </div>
                        <div class="row user-room__form-row">
                            <div class="col-sm-6">
                                <label class="user-room__label" for="phone">Телефон</label>
                                <input class="user-room__input" type="text" name="phone" value="{!! $user_data->phone ? $user_data->phone : '' !!}" disabled="">
                            </div>
                            <div class="col-sm-6">
                                <label class="user-room__label" for="email">E-mail</label>
                                <input class="user-room__input" type="text" name="email" value="{{ $user->email ? $user->email : '' }}" disabled="">
                            </div>
                        </div>
                        <div class="row user-room__form-row">
                            <div class="col-sm-6">
                                <a href="/logout" class="change-data__btn">Выйти</a>
                            </div>
                            <div class="col-sm-6">
                                <a href="/user/change-data" class="change-data__btn">Изменить личные данные</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection