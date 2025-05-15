<?php
$BreadcrumbList = ($breadcrumbs->namespace === 'admin')
    ? ''
    : "itemscope itemtype='https://schema.org/BreadcrumbList'";
$ListItem       = ($breadcrumbs->namespace === 'admin')
    ? ''
    : "itemprop='itemListElement' itemscope itemtype='https://schema.org/ListItem'";

?>


<nav class='<?= $breadcrumbs->class ?>' <?= $BreadcrumbList; ?>>
    <ul>
        <li <?= $ListItem; ?>>
            <a itemprop='item'
               href="<?= $breadcrumbs->categoryHref; ?>"
            >
            <span itemprop="name">
                Категории
        </span>
            </a>
            <meta itemprop="position" content="1"/>
        </li>
        <?= $breadcrumbs->breadcrumbs; ?>
    </ul>
</nav>

