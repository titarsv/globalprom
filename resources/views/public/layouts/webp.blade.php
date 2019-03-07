{{--@if(!empty($webp))--}}
{{--<picture>--}}
    {{--<source srcset="{{env('APP_URL')}}/assets/images/{{ $webp }}" type="image/webp">--}}
    {{--<source srcset="{{env('APP_URL')}}/assets/images/{{ $original }}" type="image/{{ $original_mime }}">--}}
    {{--<img src="{{env('APP_URL')}}/assets/images/{{ $original }}" @foreach($attributes as $key => $attr){{ $key }}="{{ $attr }}"@endforeach>--}}
{{--</picture>--}}
{{--@else--}}
{{--@if(!empty($original))--}}
{{--<img src="{{env('APP_URL')}}/assets/images/{{ $original }}" @foreach($attributes as $key => $attr){{ $key }}="{{ $attr }}"@endforeach>--}}
{{--@else--}}
{{--<img src="{{env('APP_URL')}}/assets/images/no_image.jpg" @foreach($attributes as $key => $attr){{ $key }}="{{ $attr }}"@endforeach>--}}
{{--@endif--}}
{{--@endif--}}

@if(!empty($webp))
    <picture>
        <source
                @if($lazy == 'slider')
                data-lazy="/assets/images/{{ $webp }}" srcset="/images/webp/pixel.webp"
                @elseif($lazy == 'static')
                data-src="/assets/images/{{ $webp }}" srcset="/images/webp/pixel.webp"
                @else
                srcset="/assets/images/{{ $webp }}"
                @endif
                type="image/webp">
        <source
                @if($lazy == 'slider')
                data-lazy="/assets/images/{{ $original }}" srcset="/images/pixel.{{ $original_mime }}"
                @elseif($lazy == 'static')
                data-src="/assets/images/{{ $original }}" srcset="/images/pixel.{{ $original_mime }}"
                @else
                srcset="/assets/images/{{ $original }}"
                @endif
                type="image/{{ $original_mime }}">
        <img
                @if($lazy == 'slider')
                data-lazy="/assets/images/{{ $original }}"
                src="/images/pixel.jpg"
                @elseif($lazy == 'static')
                src="/images/pixel.jpg"
                @else
                src="/assets/images/{{ $original }}"
        @endif
        @foreach($attributes as $key => $attr) {{ $key }}="{{ $attr }}"@endforeach>
    </picture>
@else
    @if(!empty($original))
        <img src="/assets/images/{{ $original }}" @foreach($attributes as $key => $attr){{ $key }}="{{ $attr }}"@endforeach>
    @else
        <img src="/assets/images/no_image.jpg" @foreach($attributes as $key => $attr){{ $key }}="{{ $attr }}"@endforeach>
    @endif
@endif