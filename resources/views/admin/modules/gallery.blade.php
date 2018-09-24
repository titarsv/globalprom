@include('admin.layouts.header')
@extends('admin.layouts.main')
@section('title')
    Модули
@endsection
@section('content')

    <h1>{!! $module->name !!}</h1>

    @if (session('message-success'))
        <div class="alert alert-success">
            {{ session('message-success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @elseif(session('message-error'))
        <div class="alert alert-danger">
            {{ session('message-error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="form">
        <form method="post">
            {!! csrf_field() !!}
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Настройки модуля</h4>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-right">Статус</label>
                                <div class="form-element col-sm-10">
                                    <select name="status" class="form-control">
                                        @if($module->status)
                                            <option value="1" selected>Включить</option>
                                            <option value="0">Выключить</option>
                                        @else
                                            <option value="1">Включить</option>
                                            <option value="0" selected>Выключить</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-right">Максимальное количество фотографий</label>
                                <div class="form-element col-sm-10">
                                    <input type="text" name="quantity" class="form-control" value="{!! isset($settings->quantity) ? $settings->quantity : 6 !!}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Слайды</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table slideshow-images">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="success">
                                        <th align="center" class="col-md-4">Изображение</th>
                                        <th align="center" class="col-md-4">Инфо</th>
                                        <th align="center" class="col-md-4">Действия</th>
                                    </tr>
                                </thead>
                                <tbody id="modules-table">
                                    @forelse($slideshow as $key => $slide)
                                        <tr>
                                            <td class="col-md-4">
                                                <input type="hidden" id="module-image-{!! $key !!}" name="slide[{!! $key !!}][image_id]" value="{!! $slide->image_id !!}" />
                                                <div id="module-image-output-{!! $key !!}" class="module-image">
                                                    <img src="/assets/images/{!! $slide->image->href !!}" />
                                                    <button type="button" class="btn btn-del" data-delete="{!! $key !!}" data-toggle="tooltip" data-placement="bottom" title="Удалить изображение">X</button>
                                                    <button type="button" data-open="module-image" data-key="{!! $key !!}" class="btn">Выбрать изображение</button>
                                                </div>
                                            </td>
                                            <td class="col-md-4">
                                                <div>
                                                    <p>Название</p>
                                                    <input type="text" name="slide[{!! $key !!}][slide_name]" class="form-control" value="{!! json_decode($slide->slide_data)->slide_name !!}" />
                                                    <p>Раздел</p>
                                                    <input type="text" name="slide[{!! $key !!}][slide_cat]" class="form-control" value="{!! json_decode($slide->slide_data)->slide_cat !!}" />
                                                </div>
                                            </td>
                                            <td class="col-md-4" align="center">
                                                <button class="btn btn-danger" onclick="$(this).parent().parent().remove();">Удалить</button>
                                                @if($key == count($slideshow) - 1)
                                                    <input type="hidden" value="{!! $key !!}" id="slideshow-iterator" />
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="empty">
                                            <td colspan="3" align="center">Нет добавленных слайдов!<input type="hidden" value="0" id="slideshow-iterator" /></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td align="center"><button type="button" id="button-add-photo" class="btn">Добавить фото</button></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <button type="submit" class="btn">Сохранить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
@section('before_footer')
    @include('admin.layouts.imagesloader')
@endsection
