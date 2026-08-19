@php
    use app\service\AuthService\AuthService;
    use app\view\components\Icon\Icon;
    $user = AuthService::getUser();

@endphp

@if (!$user)

    <menu class="guest-menu" aria-label="login">
        {!!Icon::user()!!}
        <span>Вход</span>
    </menu>

@else

    <div class="user-menu">

        <img src="{!!$user->avatar() ?? ''!!}" alt="">

        <div class="credits">
            <div class="fio">{!!$user->fi()!!}</div>
            <div class="email">{!!$user->mail()!!}</div>
        </div>

        <div class="menu">
            <a href="/auth/profile">Изменить свой профиль</a>
            @if ($user->isEmployee() || $user->isAdmin())
                <a class="list__item" href="/adminsc">Admin</a>
            @endif

            <a href="/auth/logout" aria-label="logout" onclick="localStorage.setItem('id', null)">
                {!!Icon::logout2()!!}Выход</a>
        </div>
    </div>

@endif

