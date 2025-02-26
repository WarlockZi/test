<div class="item_content">

    <!--  TABLE  -->
    <?php

    foreach ($this->fields as $field) {
        include ROOT . '/app/view/components/Builders/ItemBuilder/row.php';
    }
    include ROOT . '/app/view/components/Builders/ItemBuilder/buttons.php'

    ?>

</div>



