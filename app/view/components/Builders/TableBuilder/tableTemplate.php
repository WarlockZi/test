<div custom-table
    <?= $class; ?>
    <?= $dataModel; ?>
    <?= $dataRelation; ?>
    <?= $dataRelationType; ?>
>

    <div class='table-title'><?= $pageTitle; ?></div>
    <?=$header ; ?>

    <div class="custom-table"
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
        <?php if (!empty($items)): ?>


            <?php foreach ($items as $item): ?>

                <?php foreach ($columns as $field => $c): ?>

                    <?php if ($c->html): ?>
                        <?= $c->html ?>
                    <?php else: ?>

                        <div
                                data-id='<?= $item['id']??0; ?>'
                                <?= $c->dataField; ?>
                                <?= $c->pivot; ?>
                                <?= $c->attach; ?>
                                <?= $c->class; ?>
                                <?= $c->contenteditable; ?>
                        >
                            <?= $c->getData($c, $item, $field); ?>
                        </div>
                    <?php endif; ?>

                <?php endforeach; ?>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>

    <?php if (empty($items)): ?>
        <h3 class="no-items">Элементы не найдены</h3>
    <?php endif; ?>

    <!--  ADD BUTTON  -->
    <div class="buttons">
        <?= $add; ?>
    </div>


</div>
