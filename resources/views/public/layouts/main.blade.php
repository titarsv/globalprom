<!DOCTYPE html>
<html lang="ru">
@include('public.layouts.header')

<body class="account-body{{ Request::path()=='/' ? ' home' : '' }}">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PDMLRN8"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @include('public.layouts.header-main')

    @yield('breadcrumbs')
    @yield('content')
    @include('public.layouts.footer')
	@include('public.layouts.footer-scripts')
</body>
</html>