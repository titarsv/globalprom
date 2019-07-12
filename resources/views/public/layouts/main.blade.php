<!DOCTYPE html>
<html lang="ru">
@include('public.layouts.header')

<body class="account-body{{ Request::path()=='/' ? ' home' : '' }}" id="top">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PDMLRN8"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <noscript>
        <img src="https://www.facebook.com/tr?id=664405463896680&ev=PageView&noscript=1" height="1" width="1" alt="fb"/>
    </noscript>
    @include('public.layouts.header-main')
    <div id="main-wrapper">
        @yield('breadcrumbs')
        @yield('content')
    </div>
    @include('public.layouts.footer')
	@include('public.layouts.footer-scripts')
</body>
</html>