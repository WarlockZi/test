@php
    use app\service\AuthService\Auth;
    use app\view\components\Icon\Icon;
@endphp


<li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
    @if(!$breadcrumbs->lastItemIsLink
        && $breadcrumbs->itemsCount===$position)
        <div itemprop="item">
            <span itemprop="name">{!! $item['name']!!}</span>
        </div>
    @else
        <a itemprop="item" href="/category/{!! $item['own_properties']['path'] !!}">
            <span itemprop="name">{!! $item['name']!!}</span>
        </a>
    @endif

    <meta itemprop="position" content="{!! $position !!}">


    <div class="card-panel">
        @if (Auth::userIsAdmin())

            <a
                    href="/adminsc/category/edit/<?= $item['id'] ?>"
                    class="edit card-panel-item"
            >
                    <?= Icon::edit(); ?>

            </a>
        @endif
    </div>
</li>
