@if(!empty($webp))
<picture>
    <source
            @if($lazy == 'slider')
            data-lazy="{{env('APP_URL')}}{{ $webp }}"
            @elseif($lazy == 'static')
            data-src="{{env('APP_URL')}}{{ $webp }}" srcset="/images/webp/pixel.webp"
            @else
            srcset="{{env('APP_URL')}}{{ $webp }}"
            @endif
            type="image/webp">
    <source
            @if($lazy == 'slider')
            data-lazy="{{env('APP_URL')}}{{ $original }}"
            @elseif($lazy == 'static')
            data-src="{{env('APP_URL')}}{{ $original }}" srcset="/images/pixel.{{ $original_mime }}"
            @else
            srcset="{{env('APP_URL')}}{{ $original }}"
            @endif
            type="image/{{ $original_mime }}">
    <img @if($lazy == 'slider')
         data-lazy="/assets/images/{{ $original }}"
         src="/images/pixel.jpg"
         @elseif($lazy == 'static')
         src="/images/pixel.jpg"
         @else
         src="/assets/images/{{ $original }}"
    @endif
    @foreach($attributes as $key => $attr){{ $key }}="{{ $attr }}"@endforeach>
</picture>
@else
@if(!empty($original))
<img src="{{env('APP_URL')}}{{ $original }}" @foreach($attributes as $key => $attr){{ $key }}="{{ $attr }}"@endforeach>
@else
<img src="{{env('APP_URL')}}/assets/images/no_image.jpg" @foreach($attributes as $key => $attr){{ $key }}="{{ $attr }}"@endforeach>
@endif
@endif