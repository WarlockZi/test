<!--  BUTTONS  -->
<div class="item_buttons">

    <?php use app\core\Icon;

	 if ($field->isDel()): ?>
	  <div class="del"
	       data-model="<?= $field->getModelName(); ?>"
	       data-id="<?= $field->item['id']; ?>"
	  >
			 <?= Icon::trashIcon() ?>
	  </div>

     <?php endif; ?>

    <?php if ($field->isSoftDel()): ?>
	  <div soft-del>
			 <?= Icon::trashIcon() ?>
	  </div>
    <?php endif; ?>


    <?php if ($field->isSave()): ?>
	  <div class="save"
	       data-model="<?= $field->getModelName(); ?>"
	       data-id="<?= $field->item['id']; ?>">
			 <?= Icon::save();?>
	  </div>
    <?php endif; ?>

    <?php if ($field->isToList()): ?>
	  <a href="<?=$field->getToListHref(); ?>"
	     class="to-list">
			 <?= $field->getToListText() ?>
	  </a>
    <?php endif; ?>

</div>