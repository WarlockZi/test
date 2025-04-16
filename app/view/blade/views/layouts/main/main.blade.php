@php
    use app\Services\AuthService\Auth;
    use app\view\Icon;
@endphp

        <!DOCTYPE html>
<html lang="ru">
<head>
    <!--	MainLaiout.blade.php-->
    <meta charset="utf-8">
    <meta name="phpSession" content="@php $_SESSION['phpSession'] ?? ''; @endphp">
    <meta http-equiv="cleartype" content="on"/>
    <meta name="MobileOptimized" content="320">
    <meta name="HandheldFriendly" content="True">
    <meta name="mobile-web-app-capable" content="yes">

    <meta name="yandex-verification" content="003253e624aad5b6"/>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $link = DEV ? PIC_SERVICE."logo-square-dev.svg" : PIC_SERVICE."logo-square.svg";
    @endphp
    <link rel='icon' href='{{$link}}' type='image/svg+xml'>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
          rel="stylesheet">

    <title>@yield('title', 'Default Title')</title>
    <meta name="description" content="@yield('description', 'Default Description')">
    <meta name="keywords" content="@yield('keywords', '')">

    <script src="https://yastatic.net/s3/passport-sdk/autofill/v1/sdk-suggest-with-polyfills-latest.js"></script>
    <script src="https://yastatic.net/s3/passport-sdk/autofill/v1/sdk-suggest-token-with-polyfills-latest.js"></script>

    @include('layouts.main.header.assets')

    <link rel='stylesheet' href='/public/custom.css'>
</head>

<body class="preload">

@include('layouts.main.header.index')


<div class="user-content-wrap">
    <main class="user-content">
        @if (Auth::userIsAdmin())
            <div class="admin-gap"></div>
        @endif


        @yield('exceptions')

        @yield('content')


    </main>
    <!--    <div class="chat-icon" title="Чат">-->@php //=Icon::chat2();@endphp<!--</div>-->
    <form class="chat-form" id="chatForm">
        <div class="modal-close">@php echo Icon::close() @endphp</div>
        <div class="messages"></div>
        <input type="text" class="chat-name-input" data-user-name placeholder="Здравствуйте, как Вас зовут?">
    </form>


</div>


@include('layouts.main.footer.footer')


<div class="modal invisible" data-modal="default">
    <div class="overlay"></div>
    <div class="wrap">
        <div class="box">
            <div class="title">Заголовок</div>
            <div class="modal-close">@php echo Icon::close() @endphp</div>
            <div class="content"></div>
        </div>
    </div>

</div>
<button id="fixed-call-me" class="fixed call-me" title="Заказать обратный звонок">@php echo Icon::phone(); @endphp</button>
<button id="hoist" class="fixed hoist" title="Наверх">@php echo Icon::scrollUp1(); @endphp</button>
</body>
</html>