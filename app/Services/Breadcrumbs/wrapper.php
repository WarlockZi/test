<?php
$BreadcrumbList = ($obj['namespace'] === 'admin')
    ? ''
    : "itemscope itemtype='https://schema.org/BreadcrumbList'";
$ListItem       = ($obj['namespace'] === 'admin')
    ? ''
    : "itemprop='itemListElement' itemscope itemtype='https://schema.org/ListItem'";

?>


<nav class='<?= $obj['class']; ?>' <?= $BreadcrumbList; ?>>
    <ul>
        <li <?= $ListItem; ?>>
            <a itemprop='item'
               href="<?= $obj['categoryHref']; ?>"
            >
            <span itemprop="name">
                Категории
        </span>
            </a>
            <meta itemprop="position" content="1"/>
        </li>
        <?= $obj['breadcrumbs']; ?>
    </ul>
</nav>

