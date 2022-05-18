<div class="item_header">

	<? if ($this->pageTitle): ?>
	  <div class="page-title"><?= $this->pageTitle ?></div>
	<? endif; ?>

</div>

<div class="item_content"
     data-table="<?= $this->tableClassName ?>"
     data-model="<?= $this->modelName ?>"
     data-id="<?= $this->item['id'] ?>"
>
	<!--  TABLE  -->
	<? foreach ($this->fields as $fieldName => $data): ?>
		<? $contenteditable = (isset($data['contenteditable']) && $data['contenteditable']) ? 'contenteditable' : ''; ?>
		<? $required = (isset($data['required']) && $data['required']) ? 'required' : ''; ?>
	  <div class="row">
		  <div class="field"><?= $fieldName ?></div>
		  :
		  <div class="value"
					<? if (array_key_exists('html', $data)): ?>
		  >
					<?= $data['html']; ?>
					<? else: ?>
				 >
				 <div class="text"
							 <?= "data-field={$data['field']}"; ?>
							 <?= $contenteditable; ?>
							 <?= $required; ?>
				 >
							 <?= $this->item[$data['field']] ?>
				 </div>
					<? endif; ?>
		  </div>


	  </div>

	<? endforeach; ?>
	<div class="buttons_wrap">
		 <? include ROOT . '/app/view/components/CustomCatalogItem/buttons.php' ?>
	</div>

</div>



