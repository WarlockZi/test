@php
    use app\service\AuthService\Auth;
        $link = DEV ? PIC_SERVICE."logo-square-dev.svg" : PIC_SERVICE."logo-square.svg";
        $user = Auth::getUser();
@endphp
        <!DOCTYPE html>
<html lang="ru">
<!--ADMIN-LAYOUT-->
<head>
    <meta name="phpSession" content="<?= $_SESSION['phpSession'] ?? ''; ?>">
    <meta name="robots" content="noindex,nofollow"/>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">


    {!! $layout->vite(['Admin/admin.js']) !!}

</head>

<body class="preload">

<div class="admin-layout">

    @include('layouts.admin.sidebar.index', compact('user'))
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