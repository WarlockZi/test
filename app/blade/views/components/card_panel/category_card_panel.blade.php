@php
    use app\service\AuthService\Auth;

    use app\view\components\Icon\Icon;
    $isAdmin = Auth::userIsAdmin();
//                xdebug_break();
    $link = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/short/';
@endphp

<div class="card-panel">

    <div class="short-link card-panel-item"
         title='Скопировать короткую ссылку'
         data-shortLink={{$link}}{{ $child['own_properties']['short_link']}}
    >
        {!!Icon::link()!!}
    </div>
    @if ($isAdmin)
        <a href="/adminsc/category/edit/<?= $child['id'] ?>"
           class="edit card-panel-item">{!!Icon::edit()!!}</a>
    @endif
</div>
