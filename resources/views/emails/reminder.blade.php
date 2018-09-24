<div class="header" style="text-align: center;">
    <img src="{!! url('/images/logo.jpg') !!}" alt="logo"  title="Globalprom" width="224" height="36" />
    <p style="font-size: 20px;">Восстановление пароля</p>
</div>
<p>Для того, чтобы восстановить пароль, пожалуйста, перейдите по <a href="{{ url('/lostpassword') . '?id=' . $user->id . '&code=' . $reminder->code }}">данной</a> ссылке.</p>