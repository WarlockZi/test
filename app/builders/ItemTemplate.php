<?= $data->getPageTitle(); ?>
<div class="item-wrap" <?= $data->getDataModel(); ?> <?= $data->getDataId(); ?>>

    <?php if ($data->getTabs()) {
        include __DIR__ . '/withTabs.php';
    } else {
        include __DIR__ . '/noTabs.php';
    }
    ?>
</div>
