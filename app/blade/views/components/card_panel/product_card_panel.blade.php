@php

    use app\service\AuthService\AuthService;
    use \app\view\components\Icon\Icon;

@endphp

<div class="card-panel">

    <div class="short-link card-panel-item"
         title='Скопировать короткую ссылку'
         data-shortLink={!!data_get($product, 'own_properties.short_link', '')!!}
    >
        {!!Icon::link()!!}
    </div>
    {{--@deb--}}
    <div class="compare card-panel-item {!!isset($product['compare']) ? 'green' : ''!!}"
         data-compare="{!!is_null($product['compare'])?'false':'true'!!}"
         title='Добавить в сравнение'
    >
        {!!Icon::chart()!!}
    </div>

    <div class="like card-panel-item {!! isset($product['like'])? 'red' : '' !!}"
         data-like="false"
         title='Добавить в избранное'
    >
        {!!Icon::heart()!!}
    </div>
    @if(AuthService::getUser()?->isAdmin())
        <a href="/adminsc/product/edit/{!!$product['id']!!}"
           class="edit card-panel-item"
        >
            {!!Icon::edit()!!}
        </a>
    @endif
</div>
