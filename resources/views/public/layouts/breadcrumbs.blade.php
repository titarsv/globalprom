@if ($breadcrumbs)
    <nav class="breadrumbs">
        <div class="container">
            <ul class="breadrumbs-list">
                @foreach ($breadcrumbs as $breadcrumb)
                    @if (!$breadcrumb->last)
                        <li class="breadrumbs-item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="{{ $breadcrumb->url }}" itemprop="url"><span itemprop="title">{{ $breadcrumb->title }}</span></a><i>→</i></li>
                    @else
                        <li class="breadrumbs-item">{{ $breadcrumb->title }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    </nav>
@endif
