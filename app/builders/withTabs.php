<div class="item_header">
    <?php include __DIR__ . '/tabs.php' ?>
</div>

<div class="item_content">

    <section data-tab="1" class="show">

        <!--  TABLE  -->
        <?php foreach ($data->getFields() as $field): ?>
            <?php include __DIR__ .'/row.php'?>
        <?php endforeach; ?>
    </section>

    <?php $n = 2; ?>
    <?php foreach ($data->getTabs() as $k => $tab): ?>
        <section

            <?= $tab->getField(); ?>
                data-tab=<?= $n ?>>
            <?= $tab->getHtml(); ?>

        </section>
        <?php $n++; ?>
    <?php endforeach; ?>

    <?php include __DIR__  . '/buttons.php' ?>


</div>

