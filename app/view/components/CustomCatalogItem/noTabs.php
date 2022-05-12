<div class="item_header">

	<div class="page-title"><?= $this->pageTitle ?></div>


</div>

<div class="item_content"
     data-table="<?= $this->tableClassName ?>"
     data-model="<?= $this->modelName ?>"
     data-id="<?= $this->item['id'] ?>"
>
	<!--  TABLE  -->
	<? foreach ($this->fields as $fieldName => $data): ?>
	  <div class="row">
		  <div class="field"><?= $fieldName ?></div>
		  :

		  <div class="value"
					<?= isset($data['contenteditable'])?'contenteditable':''; ?>
					<?= "data-field={$data['field']}"; ?>>
					<? if (array_key_exists('html',$data)): ?>
						<?= $data['html']; ?>
					<? else: ?>
					<?= $this->item[$data['field']] ?>
					<? endif; ?>
		  </div>


	  </div>

	<? endforeach; ?>
	<div class="buttons_wrap">
		 <? include ROOT . '/app/view/components/CustomCatalogItem/buttons.php' ?>
	</div>

</div>



