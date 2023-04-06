<!--  BUTTONS  -->
<div class="item_buttons">

	<? use app\core\Icon;

	 if ($this->del): ?>
	  <div class="del"
	       data-model="<?= $this->model; ?>"
	       data-id="<?= $this->item['id']; ?>"
	  >
			 <?= Icon::trashIcon() ?>
	  </div>
	<? endif; ?>

	<? if ($this->softDel): ?>
	  <div soft-del>
			 <?= Icon::trashIcon() ?>
	  </div>
	<? endif; ?>


	<? if ($this->save): ?>
	  <div class="save"
	       data-model="<?= $this->model; ?>"
	       data-id="<?= $this->item['id']; ?>">
			 <?= Icon::save();?>
	  </div>
	<? endif; ?>

	<? if ($this->toList): ?>
	  <a href="/adminsc/<?= $this->model . $this->toListHref; ?>"
	     class="to-list">
			 <?= $this->toListText ?>
	  </a>
	<? endif; ?>

</div>