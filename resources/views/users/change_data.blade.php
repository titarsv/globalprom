@extends('public.layouts.main')

@section('meta')
    <title>Личный кабинет</title>
    <meta name="description" content="{!! $settings->meta_description !!}">
    <meta name="keywords" content="{!! $settings->meta_keywords !!}">
@endsection

@section('breadcrumbs')
    {!! Breadcrumbs::render('user') !!}
@endsection

@section('content')
    <section class="siteSection">
        <div class="container">
            <h1>Личный кабинет</h1>
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
                    @if(!empty($errors->all()))
                        <span class="error-message">
                            {!! $errors->first() !!}
                        </span>
                    @endif
                    <form class="user-room__form" method="post">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="row user-room__form-row">
                                <div class="col-sm-6">
                                    <label class="user-room__label" for="name">Ваше имя</label>
                                    <input type="text"
                                           name="first_name"
                                           id="name"
                                           class="user-room__input @if($errors->has('first_name')) input_error @endif"
                                           value="{!! old('first_name') ? old('first_name') : $user->first_name !!}">
                                </div>
                                <div class="col-sm-6">
                                    <label class="user-room__label" for="last-name">Фамилия</label>
                                    <input type="text"
                                           name="last_name"
                                           id="surname"
                                           class="user-room__input"
                                           value="{!! old('last_name') ? old('last_name') : $user->last_name !!}">
                                </div>
                            </div>
                            <div class="row user-room__form-row">
                                <div class="col-sm-6">
                                    <label class="user-room__label" for="phone">Телефон</label>
                                    <input type="text"
                                           name="phone"
                                           id="phone"
                                           class="user-room__input @if($errors->has('phone')) input_error @endif"
                                           value="{!! old('phone') ? old('phone') : $user_data->phone !!}">
                                </div>
                                <div class="col-sm-6">
                                    <label class="user-room__label" for="email">E-mail</label>
                                    <input type="text"
                                           name="email"
                                           id="email"
                                           class="user-room__input @if($errors->has('email')) input_error @endif"
                                           value="{!! old('email') ? old('email') : $user->email !!}">
                                </div>
                            </div>
                            <div class="row user-room__form-row">
                                <div class="col-sm-6">
                                    <a href="/logout" class="change-data__btn">Выйти</a>
                                </div>
                                <div class="col-sm-6">
                                    <button type="submit" class="change-data__btn">Сохранить</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection