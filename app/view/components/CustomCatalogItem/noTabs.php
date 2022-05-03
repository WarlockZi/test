<div class="custom-catalog-item__header">

	<div class="page-title"><?= $this->pageTitle ?></div>


</div>

<div class="custom-catalog-item__content"
     data-table="<?= $this->tableClassName ?>"
     data-model="<?= $this->modelName ?>"
     data-id="<?= $this->item['id'] ?>"
>
	<!--  TABLE  -->
	<? foreach ($this->fields as $fieldName => $data): ?>
	  <div class="row">
		  <div class="field"><?= $data['name'] ?></div>
		  :

			 <? if (in_array($data['data-type'], ['string', 'number'])): ?>
			 <div class="value"
						<?= $data['contenteditable']; ?>
						<?= "data-field={$fieldName}"; ?>>
						<?= $this->item[$fieldName] ?>
			 </div>
			 <? elseif (in_array($data['data-type'], ['select', 'multiselect'])): ?>
				 <?= $data['html']; ?>

			 <? elseif (in_array($data['data-type'], ['radio'])): ?>
				 <?= $data['html']; ?>

			 <? elseif (in_array($data['data-type'], ['date'])): ?>
				 <?= $data['html']; ?>
			 <? endif; ?>

	  </div>

	<? endforeach; ?>
	<div class="buttons__wrapper">
    <? include ROOT . '/app/view/components/CustomCatalogItem/buttons.php' ?>
	</div>

</div>



