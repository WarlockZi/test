<div class="custom-catalog-item__wrapper">

	<div class="custom-catalog-item"
	     data-table="<?= $this->tableClassName ?>"
	     data-model="<?= $this->modelName ?>"
	>

		<!--  TABLE  -->
		 <? foreach ($this->fields as $fieldName => $data): ?>
		  <div class="row">
			  <div class="field"><?= $data['name'] ?></div>
			  :

					<? if (in_array($data['data-type'],['string','number'])): ?>
				 <div class="value"
							 <?= $data['contenteditable']; ?>>
							 <?= $this->item[$fieldName] ?>
				 </div>
					<? elseif (in_array($data['data-type'],['select','multiselect'])): ?>
						<?= $data['select']; ?>
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
