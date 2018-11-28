@if(!empty($webp))
<picture>
    <source srcset="{{env('APP_URL')}}{{ $webp }}" type="image/webp">
    <source srcset="{{env('APP_URL')}}{{ $original }}" type="image/{{ $original_mime }}">
    <img src="{{env('APP_URL')}}{{ $original }}" @foreach($attributes as $key => $attr){{ $key }}="{{ $attr }}"@endforeach>
</picture>
@else
@if(!empty($original))
<img src="{{env('APP_URL')}}{{ $original }}" @foreach($attributes as $key => $attr){{ $key }}="{{ $attr }}"@endforeach>
@else
<img src="{{env('APP_URL')}}/assets/images/no_image.jpg" @foreach($attributes as $key => $attr){{ $key }}="{{ $attr }}"@endforeach>
@endif
@endif