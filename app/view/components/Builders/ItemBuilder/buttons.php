<!--  BUTTONS  -->
<div class="item_buttons">

	<? if ($this->del): ?>
	  <div class="del"
	       data-model="<?= $this->model; ?>"
	       data-id="<?= $this->item['id']; ?>"
	  >
			 <? include TRASH ?>
	  </div>
	<? endif; ?>

	<? if ($this->softDel): ?>
	  <div soft-del>
			 <? include TRASH ?>
	  </div>
	<? endif; ?>


	<? if ($this->save): ?>
	  <div class="save"
	       data-model="<?= $this->model; ?>"
	       data-id="<?= $this->item['id']; ?>">
			 <? include SAVE ?>
	  </div>
	<? endif; ?>

	<? if ($this->toList): ?>
	  <a href="/adminsc/<?= $this->model . $this->toListHref; ?>"
	     class="to-list">
			 <?= $this->toListText ?>
	  </a>
	<? endif; ?>

</div>