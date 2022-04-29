<!--  BUTTONS  -->
<div class="custom-catalog-item__buttons">

	<? if ($this->delBttn): ?>
	  <div class="del">
			 <? include TRASH ?>
	  </div>
	<? endif; ?>

	<? if ($this->saveBttn): ?>
	  <div class="save">
			 <? include SAVE ?>
	  </div>
	<? endif; ?>

	<? if ($this->toListBttn): ?>
	  <a href="/adminsc/<?= $this->modelName; ?>/list"
	     class="to-list">
		  К списку
	  </a>
	<? endif; ?>

</div>