<!--  BUTTONS  -->
<div class="item_buttons">

	<? if ($this->del): ?>
	  <div class="del"
	       data-model="<?=$this->model;?>"
	       data-id="<?=$this->item['id'];?>">
			 <? include TRASH ?>
	  </div>
	<? endif; ?>

	<? if ($this->save): ?>
	  <div class="save">
			 <? include SAVE ?>
	  </div>
	<? endif; ?>

	<? if ($this->toList): ?>
	  <a href="/adminsc/<?= $this->model.'/'.$this->href; ?>"
	     class="to-list">
		  К списку
	  </a>
	<? endif; ?>

</div>