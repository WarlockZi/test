@php

use app\service\AuthService\Auth;
use \app\view\components\Icon\Icon;

@endphp

<div class="card-panel">

{{--    @php(xdebug_break())--}}
    <div class="short-link card-panel-item"
         title='Скопировать короткую ссылку'
         data-shortLink= <?= $product['own_properties']['short_link']; ?>
    >
        <?= Icon::link(); ?>
    </div>

{{--    @php(xdebug_break())--}}
    <div class="compare card-panel-item {!! isset($product['compare']) ? 'green' : ''!!}"
         data-compare="false"
         title='Добавить в сравнение'
    >
        <?= Icon::chart(); ?>
    </div>

{{--         @php(xdebug_break())--}}
    <div class="like card-panel-item {!! isset($product['like'])? 'red' : '' !!}"
         data-like="false"
         title='Добавить в избранное'
    >
        <?= Icon::heart(); ?>
    </div>
    @if(Auth::getUser()?->isAdmin())
        <a href="/adminsc/product/edit/<?= $product['id'] ?>"
           class="edit card-panel-item"
        >
                <?= Icon::edit(); ?>
        </a>
    @endif
</div>
