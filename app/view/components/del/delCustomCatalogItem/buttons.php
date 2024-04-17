<!--  BUTTONS  -->
<div class="item_buttons">

	<? use app\core\Icon;

	 if ($this->delBttn): ?>
	  <div class="del"
	       data-model="<?=$this->modelName;?>"
	       data-id="<?=$this->item['id'];?>">
			 <?=Icon::trashIcon() ?>
	  </div>
	<? endif; ?>

	<? if ($this->saveBttn): ?>
	  <div class="save">

	  </div>
	<? endif; ?>

	<? if ($this->toListBttn): ?>
	  <a href="/adminsc/<?= $this->modelName; ?>/list"
	     class="to-list">
		  К списку
	  </a>
	<? endif; ?>

</div>