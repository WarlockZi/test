@php
    use app\service\Vite\Vite;
//        xdebug_break();
@endphp
        <!DOCTYPE html>
<html lang="ru">

<!--ADMIN-LAYOUT-->
<head>
    <meta name="phpSession" content="<?= $_SESSION['phpSession'] ?? ''; ?>">
    <meta name="robots" content="noindex,nofollow"/>
    <meta charset="utf-8">
    <link rel='icon' href='{{DEV ? PIC_SERVICE."logo-square-dev.svg" : PIC_SERVICE."logo-square.svg"}}'
          type='image/svg+xml'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {!! (APP->get(Vite::class))->vite(['Admin/admin.js']) !!}
</head>

<body class="preload">

<div class="admin-layout">
    @include('layouts.admin.header.sidebar.index')
{{--    @include('layouts.admin.header.sidebar.admin_menu_accordion')--}}
{{--    @include('layouts.admin.sidebar.index')--}}
    @include('layouts.admin.header.header')

    <div class="admin-layout_content content">

        <div class="adm-content">
            @yield('errors')
            @yield('content')

        </div>

    </div>


</div>

</body>
</html>