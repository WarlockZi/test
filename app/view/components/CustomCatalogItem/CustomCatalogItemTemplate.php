<div class="custom-catalog-item__wrapper">

	<div class="custom-catalog-item"
	     data-table="<?= $this->tableClassName ?>"
	     data-model="<?= $this->modelName ?>"
	>

		<!--  TABLE  -->
		 <? foreach ($this->fields as $field => $value): ?>
		  <div class="row">
			  <div class="field"><?= $value['name'] ?></div>
			  :
					<? if ($value['data-type']==='string'): ?>
				 <div class="value"
							 <?= $value['contenteditable']; ?>>
							 <?= $this->item[$field] ?>
				 </div>
					<? elseif ($value['data-type']==='select'): ?>
					<?=$value['select'];?>
					<? endif; ?>

		  </div>

		 <? endforeach; ?>

	</div>

	<!--  BUTTONS  -->
	<div class="custom-catalog-item__buttons">

		 <? if ($this->delBttn === 'ajax'): ?>
		  <div class="del"
		       data-model="<?= $this->modelName; ?>">
					<? include TRASH ?>
		  </div>
		 <? endif; ?>

		 <? if ($this->saveBttn === 'ajax'): ?>
		  <div class="save"
		       data-model="<?= $this->modelName; ?>">
					<? include SAVE ?>
		  </div>
		 <? endif; ?>

		 <? if ($this->toListBttn): ?>
		  <a href="/adminsc/<?= $this->modelName; ?>/list"
		     class="to-list"
		     data-model="<?= $this->modelName; ?>">
			  К списку
		  </a>
		 <? endif; ?>

	</div>


</div>
