<?php
$ListItem = ($obj['namespace'] === 'admin')
    ? ''
    : "itemprop='itemListElement' itemscope itemtype='https://schema.org/ListItem'";

$tagStart = (($obj['namespace'] === 'admin') && $obj['isLastLink'])
    ? "<a itemprop='item' href='{$obj['slug']}'>"
    : "<div itemprop='item' >";

$tagEnd = (($obj['namespace'] === 'admin') && $obj['isLastLink'])
    ? "</a>"
    : "</div>";
?>
<li <?= $ListItem; ?>>

<?= $tagStart ?>
    <span itemprop="name">
        <?= $obj['category']->name; ?>
        </span>
<?= $tagEnd; ?>

    <meta itemprop="position" content="<?= $obj['index']+1; ?>"/>
<?= $obj['panel']; ?>
    </li><?= $obj['breadcrumbs']; ?>