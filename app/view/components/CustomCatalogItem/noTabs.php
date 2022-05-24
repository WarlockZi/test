<div class="item_header">

	<? if ($this->pageTitle): ?>
	  <div class="page-title"><?= $this->pageTitle ?></div>
	<? endif; ?>

</div>
<div class="item_content">

	<!--  TABLE  -->
	<? foreach ($this->fields as $fieldName => $data): ?>
		<? $contenteditable = (isset($data['contenteditable']) && $data['contenteditable']) ? 'contenteditable' : ''; ?>
		<? $required = (isset($data['required']) && $data['required']) ? 'required' : ''; ?>
	  <div class="row">
		  <div class="field"><?= $fieldName ?></div>
		  :
			 <? include ROOT . '/app/view/components/CustomCatalogItem/value.php' ?>
	  </div>

	<? endforeach; ?>
	<? include ROOT . '/app/view/components/CustomCatalogItem/buttons.php' ?>

</div>



