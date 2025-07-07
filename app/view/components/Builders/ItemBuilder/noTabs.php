<div class="item_content">

    <!--  TABLE  -->
    <?php foreach ($this->fields as $field): ?>
        <?php include ROOT . '/app/view/components/Builders/ItemBuilder/row.php' ?>
    <?php endforeach; ?>

    <?php include ROOT . '/app/view/components/Builders/ItemBuilder/buttons.php' ?>

</div>



