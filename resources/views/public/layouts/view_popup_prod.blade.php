<div id="view_popup_prod" class="view-popup">
    <div class="container">
        <div class="row">
            <div class="col-sm-offset-2 col-sm-8 col-xs-12">
                <div class="product-slider view_popup_prod-slider" data-index="{{ $active }}">
                    @forelse($gallery as $i => $image)
                        @if(is_object($image['image']))
                            <div data-index="{{ $i }}"{{ $i == $active ? ' class=active' : '' }}>
                                <div class="img-wrp">
                                    {!! $image['image']->webp_image('product', ['alt' => empty($image['alt']) ? '' : $image['alt'], 'title' => empty($image['title']) ? '' : $image['title'], 'itemprop' => 'image']) !!}
                                </div>
                            </div>
                        @endif
                    @empty
                        <div data-index="0"{{ 0 == $active ? ' class=active' : '' }}>
                            <div class="img-wrp">
                                <img src="/assets/images/no_image.jpg" alt="{{ $product->name }}">
                            </div>
                        </div>
                    @endforelse
                    @if(!empty($product->video))
                        <div data-index="{{ isset($i) ? ($i + 1) : 0 }}"{{ (isset($i) ? ($i + 1) : 0) == $active ? ' class=active' : '' }}>
                            <div class="iframe-wrapper">
                                <iframe src="{{ $product->video }}" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
                            </div>
                        </div>
                    @endif
                </div>
                <button title="Close (Esc)" type="button" class="mfp-close">×</button>
            </div>
        </div>
    </div>
</div>