@php
    use app\service\AuthService\Auth;use app\view\components\Icon\Icon;
@endphp

{{--@deb--}}
<li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
    @if(!$breadcrumbs['lastItemIsLink'] && $breadcrumbs['itemsCount']===$position+1)
        <div itemprop="item">
            <span itemprop="name">
                {!!mb_strtoupper(data_get($item,'own_properties.breadcrumbs_name')??$item['name'])!!}
            </span>
        </div>

    @else
        <a itemprop="item" href="/category/{!!$item['own_properties']['path']??'отсутств'!!}">
            <span itemprop="name">
                {!!mb_strtoupper(data_get($item,'own_properties.breadcrumbs_name')??$item['name'])!!}
            </span>
        </a>
    @endif

    <meta itemprop="position" content="{!!$position+1!!}">


    <div class="card-panel">
        @if (Auth::userIsAdmin())
            <a
                    href="/adminsc/category/edit/<?= $item['id'] ?>"
                    class="edit card-panel-item"
            >
                {!!Icon::edit()!!}
            </a>
        @endif
    </div>
</li>
