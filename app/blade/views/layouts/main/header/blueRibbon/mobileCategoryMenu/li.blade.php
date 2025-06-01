@if(empty($child['children_recursive']))

    <li class="nav-item">
        <a class="nav-link" href="<?= $child['href']; ?>">
                <?= $child['name']; ?>
        </a>
    </li>

@else

    @include('layouts.main.header.blueRibbon.mobileCategoryMenu.nav-expand')

@endif

