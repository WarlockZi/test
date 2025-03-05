<div class="pages">


    <div class="tabs">

        <? foreach ($menu as $id => $item): ?>

            <div class="tab" data-id="<?= $id ?>">

                <?= $item->name; ?>
            </div>

        <? endforeach; ?>
    </div>

    <div class="pages-wrap">

        <? foreach ($menu as $id => $item): ?>

        <div class="page" data-id="<?= $id ?>">

            <div class="quill" data-id="<?= $id ?>" data-field="cotnent">
                <?= $item->content; ?>
            </div>
        </div>


        <? endforeach; ?>
    </div>

</div>
