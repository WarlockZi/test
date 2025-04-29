@php

    use app\service\AuthService\Auth;
    use app\view\Icon;
    $user = Auth::getUser();

@endphp

@if (!$user)

    <menu class="guest-menu" aria-label="login">
        @php echo Icon::user(); @endphp
        <span>Вход</span>
    </menu>

@else

    <div class="user-menu">
        <img src="@php echo $user->avatar() ?? ''; @endphp" alt="">

        <div class="credits">
            <div class="fio">@php echo $user->fi(); @endphp</div>
            <div class="email">@php echo $user->mail();@endphp</div>
        </div>

        <div class="menu">
            <a href="/auth/profile">Изменить свой профиль</a>
            @if ($user->isEmployee() || $user->isAdmin())
                <a class="list__item" href="/adminsc">Admin</a>
            @endif

            <a href="/auth/logout" aria-label="logout" onclick="localStorage.setItem('id', null)">
                @php echo Icon::logout2(); @endphpВыход</a>
        </div>
    </div>

@endif

