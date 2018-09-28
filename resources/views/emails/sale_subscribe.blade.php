<div class="header" style="text-align: center;">
    <img src="{!! url('/images/logo.png') !!}" alt="logo" title="Globalprom" width="224" height="36" />

    <p style="font-size: 20px;">Новое сообщение на сайте Globalprom!</p>

    @if(!empty($$phone))
    <p style="font-size: 20px;">Телефон:<b>{{ $phone }}</b></p>
    @endif
    @if(!empty($email))
        <p style="font-size: 20px;">Email:<b>{{ $email }}</b></p>
    @endif

    <p>Хочу получать информацию о скидках и специальных предложениях.</p>
</div>