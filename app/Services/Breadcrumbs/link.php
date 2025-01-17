<?php
$ListItem = ($obj['namespace'] === 'admin')
    ? ''
    : "itemprop='itemListElement' itemscope itemtype='https://schema.org/ListItem'";

?>

    <li
        <?= $ListItem; ?>
    >
        <a
                href="<?= $obj['slug']; ?>"
                itemprop='item'
        >

        <span itemprop="name">
        <?= $obj['category']->name; ?>
        </span>
        </a>
        <meta itemprop="position" content="<?= $obj['index']+1; ?>"/>
        <?= $obj['panel']; ?>
    </li>
<?= $obj['breadcrumbs']; ?>