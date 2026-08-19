@php
    use app\service\AuthService\AuthService;
    $user = AuthService::getUser();
@endphp

@if ($user?->isAdmin())

    <div class="admin-panel">

        <div class="row">
            <a href="/adminsc/report/filter">фильтры</a>
            <a href="/adminsc/cache/clear" id="cache-clear">Очистить кэш</a>
            <label class="item">Log bar
                <input type="checkbox">
            </label>


            @if($user->isSU())
                <a href="/zip/download">Download</a>
                <a href="/adminsc/sync">Sync</a>
                <a href="/adminsc/errors">Errors</a>
                <a href="/adminsc/syncmanual">sync manual</a>
            @endif

            @if($user->isOlya())
                <a href="/adminsc/syncmanual">sync manual</a>

            @endif

        </div>

    </div>
@endif

