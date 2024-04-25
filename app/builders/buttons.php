<!--  BUTTONS  -->
<div class="item_buttons">

	<? use app\core\Icon;

	 if ($data->isDel()): ?>
	  <div class="del"
	       data-model="<?= $data->getModelName(); ?>"
	       data-id="<?= $data->item['id']; ?>"
	  >
			 <?= Icon::trashIcon() ?>
	  </div>

	<? endif; ?>

	<? if ($data->isSoftDel()): ?>
	  <div soft-del>
			 <?= Icon::trashIcon() ?>
	  </div>
	<? endif; ?>


	<? if ($data->isSave()): ?>
	  <div class="save"
	       data-model="<?= $data->getModelName(); ?>"
	       data-id="<?= $data->item['id']; ?>">
			 <?= Icon::save();?>
	  </div>
	<? endif; ?>

	<? if ($data->isToList()): ?>
	  <a href="<?=$data->getToListHref(); ?>"
	     class="to-list">
			 <?= $data->getToListText() ?>
	  </a>
	<? endif; ?>

</div>