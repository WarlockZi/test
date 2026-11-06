@php
    use app\service\Vite\Vite;
@endphp
        <!DOCTYPE html>
<html lang="ru">

<!--ADMIN-LAYOUT-->
<head>
    <meta name="CSRF" content="{!!generateCsrfToken()!!}">
    <meta name="robots" content="noindex,nofollow"/>
    <meta charset="utf-8">
    <link rel='icon' href='{{DEV ? PIC_SERVICE."logo-square-dev.svg" : PIC_SERVICE."logo-square.svg"}}'
          type='image/svg+xml'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {!!(APP->get(Vite::class))->vite(['Admin/admin.js'])!!}


</head>

<body class="preload">

<div class="admin-layout">
    @include('layouts.admin.header.sidebar.index')
    @include('layouts.admin.header.header')

    <div class="admin-layout_content content">

        <div class="adm-content">
            @yield('errors')
            @yield('content')

        </div>

    </div>

</div>

@include('layouts.admin.footer.bottom-panel')

</body>
</html>