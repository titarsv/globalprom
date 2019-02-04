{!! '<'.'?'.'xml version="1.0" encoding="UTF-8" ?>' !!}
<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
    <channel>
        <title>OOO "GlobalProm"</title>
        <link>{{env('APP_URL')}}/</link>
        <g:description>RSS 2.0 product data feed</g:description>
        @foreach($products as $product)
            <item>
                <g:id>{{ $product['ID'] }}</g:id>
                <g:title>{{ $product['Title'] }}</g:title>
                <g:description>{{ $product['Description'] }}</g:description>
                <g:link>{{ $product['Link'] }}</g:link>
                <g:image_link>{{ $product['Image_​link'] }}</g:image_link>
                <g:availability>in stock</g:availability>
                <g:price>{{ $product['Price'] }} UAH</g:price>
                <g:brand>GlobalProm</g:brand>
                <g:condition>new</g:condition>
            </item>
        @endforeach
    </channel>
</rss>