@php
        use app\view\Icon;
@endphp
<!--  BUTTONS  -->
<div class="item_buttons">


    @if ($catItem['del'])
        <div class="del"
             data-model="<?= $catItem['model']; ?>"
             data-id="<?= $catItem['item']['id']; ?>"
        >
            <?= Icon::trashIcon() ?>
        </div>

    @endif

    @if ($catItem['softDel'])
        <div soft-del>
            <?= Icon::trashIcon() ?>
        </div>
    @endif


    @if ($catItem['save'])
        <div class="save"
             data-model="<?= $catItem['model']; ?>"
             data-id="<?= $catItem['item']['id']; ?>">
            <?= Icon::save(); ?>
        </div>
    @endif

    <?php if ($catItem['toList']): ?>
        <a href="<?= $catItem['toListHref']; ?>"
           class="to-list">
            <?= $catItem['toListText'] ?>
        </a>
    <?php endif; ?>

</div>