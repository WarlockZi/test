<div class='page-title'><?= $pageTitle; ?></div>
<div
        class="item-wrap"
        data-model = "<?= $modelName; ?>"
        data-id="<?= $item['id']; ?>"
>

    <?php if ($tabs) {
        include __DIR__ . '/withTabs.php';
    } else {
        include __DIR__ . '/noTabs.php';
    }
    ?>
</div>
