@php
    use app\service\AuthService\Auth;
    use app\view\Icon;

@endphp


<li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">

    @if($lastItemIsLink && $itemsCount=$position+1)
        <a itemprop="item" href="{!! $item['own_properties']['path'] !!}">
            <span itemprop="name">{!! $item['name']!!}</span>
        </a>
    @else
        <div itemprop="item">
            <span itemprop="name">{!! $item['name']!!}</span>
        </div>

    @endif

    <meta itemprop="position" content="{!! $position !!}">


    <div class="card-panel">
        @if (Auth::userIsAdmin())

            <a
                    href="/adminsc/category/edit/<?= $category['id'] ?>"
                    class="edit card-panel-item"
            >
                    <?= Icon::edit(); ?>

            </a>
        @endif
    </div>
</li>
