@php
    use app\service\AuthService\Auth;
    use app\view\Icon;
    $isAdmin = Auth::userIsAdmin();
@endphp


@if ($forBreadcrumbs)
    <div class="card-panel">
        @if ($isAdmin)
            <a href="/adminsc/category/edit/<?= $category['id'] ?>"
               class="edit card-panel-item">{!! Icon::edit() !!}</a>
        @endif
    </div>
@else
    <div class="card-panel">

        <div class="short-link card-panel-item"
             title='Скопировать короткую ссылку'
             data-shortLink= {{ $category['shortLink']}}
        >
            {!! Icon::link()!!}
        </div>
        @if ($isAdmin)
            <a href="/adminsc/category/edit/<?= $category['id'] ?>"
               class="edit card-panel-item">{!! Icon::edit() !!}</a>
        @endif
    </div>
@endif