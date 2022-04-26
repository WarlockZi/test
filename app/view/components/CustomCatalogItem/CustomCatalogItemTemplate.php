<div class="custom-catalog-item__wrapper">

	<div class="custom-catalog-item"
	     data-table="<?= $this->tableClassName ?>"
	     data-model="<?= $this->modelName ?>"
	     data-id="<?= $this->item['id'] ?>"

	>

		<!--  TABLE  -->
		 <? foreach ($this->fields as $fieldName => $data): ?>
		  <div class="row">
			  <div class="field"><?= $data['name'] ?></div>
			  :

					<? if (in_array($data['data-type'],['string','number'])): ?>
				 <div class="value"
							 <?= $data['contenteditable']; ?>
							 <?= "data-field={$fieldName}"; ?>
				 >
							 <?= $this->item[$fieldName] ?>
				 </div>
					<? elseif (in_array($data['data-type'],['select','multiselect'])): ?>
						<?= $data['select']; ?>
					<? elseif (in_array($data['data-type'],['radio'])): ?>
						<?= $data['html']; ?>

					<? endif; ?>

		  </div>

		 <? endforeach; ?>

	</div>

	<!--  BUTTONS  -->
	<div class="custom-catalog-item__buttons">

		 <? if ($this->delBttn === 'ajax'): ?>
		  <div class="del">
					<? include TRASH ?>
		  </div>
		 <? endif; ?>

		 <? if ($this->saveBttn === 'ajax'): ?>
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


</div>
