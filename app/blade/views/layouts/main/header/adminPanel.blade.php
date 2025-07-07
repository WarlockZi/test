@php use app\service\AuthService\Auth; @endphp
@if (Auth::getUser()?->isAdmin())

    <div class="admin-panel">

        <div class="row">
            <a href="/adminsc/report/filter">фильтры</a>
            <a href="/adminsc/cache/clear" id="cache-clear">Очистить кэш</a>
            <label class="item">Log bar
                <input type="checkbox">
            </label>

            @if(Auth::getUser()->isSU())
                <a href="/zip/download">Download</a>
                <a href="/adminsc/sync"> Sync</a>
            @endif

            @if(Auth::getUser()->isOlya())@endif

        </div>

    </div>
@endif

