<div class="item_tabs">
    <?php include __DIR__ . '/tabs.php' ?>
</div>

<div class="item_content">

    <section data-tab="1" class="show">

        <!--  TABLE  -->
        <?php foreach ($this->fields as $field): ?>
            <?php include ROOT . '/app/view/components/Builders/ItemBuilder/row.php' ?>
        <?php endforeach; ?>
    </section>

    <?php $n = 2; ?>
    <?php foreach ($this->tabs as $k => $tab): ?>
        <section

            <?= $tab->field; ?>
                data-tab=<?= $n ?>>
            <?= $tab->html; ?>

        </section>
        <?php $n++; ?>
    <?php endforeach; ?>

    <?php include ROOT . '/app/view/components/Builders/ItemBuilder/buttons.php' ?>


</div>