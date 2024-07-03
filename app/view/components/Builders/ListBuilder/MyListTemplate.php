<div custom-list
    <?= $class; ?>
     data-relation="<?= $relation; ?>"
    <?= $dataModel; ?>
>

    <div class='list-title'><?= $pageTitle; ?></div>

    <div class="custom-list"
        <?= $grid ?>
    >

        <!--  HEADER  -->
        <?php foreach ($columns as $c): ?>
            <div
                <?= $c->classHeader; ?>
                <?= $c->type; ?>
                <?= $c->sort; ?>
            >
                <?= $c->sortIcon; ?>
                <?= $c->name; ?>
                <?= $c->search; ?>
            </div>
        <?php endforeach; ?>

        <!--  TABLE  -->

        <!--		 Empty row-->
        <?= $emptyRow; ?>

        <!--		 Data rows-->
        <?php foreach ($items as $item): ?>

            <?php foreach ($columns as $field => $c): ?>

                <?php if ($c->html): ?>
                    <?= $c->html ?>

                <?php else: ?>

                    <div
                            data-id=<?= $item['id']; ?>
                            <?= $c->dataField; ?>
                            <?= $c->class; ?>
                            <?= $c->contenteditable; ?>
                    ><?= $c->getData($c, $item, $field); ?>
                    </div>
                <?php endif; ?>

            <?php endforeach; ?>

        <?php endforeach; ?>

    </div>

    <!--  ADD BUTTON  -->
    <div class="buttons">
        <?php $add ?>
    </div>


</div>
