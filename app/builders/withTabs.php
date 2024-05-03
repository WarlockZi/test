<div class="item_header">
    <?php include __DIR__ . '/tabs.php' ?>
</div>

<div class="item_content">

    <section data-tab="1" class="show">

        <!--  TABLE  -->
        <?php foreach ($fields as $field): ?>
            <?php include __DIR__ .'/row.php'?>
        <?php endforeach; ?>
    </section>

    <?php $n = 2; ?>
    <?php foreach ($tabs as $k => $tab): ?>
        <section

            <?= $field->getField(); ?>
                data-tab=<?= $n ?>>
            <?= $tab->html; ?>

        </section>
        <?php $n++; ?>
    <?php endforeach; ?>

    <?php include __DIR__  . '/buttons.php' ?>


</div>

