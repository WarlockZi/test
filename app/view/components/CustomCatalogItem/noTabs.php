<div class="item_header">


	  <div class="page-title"><?= $this->pageTitle??''; ?></div>


</div>
<div class="item_content">

	<!--  TABLE  -->
	<? foreach ($this->fields as $fieldName => $data): ?>
		<? $contenteditable = (isset($data['contenteditable']) && $data['contenteditable']) ? 'contenteditable' : ''; ?>
		<? $required = (isset($data['required']) && $data['required']) ? 'required' : ''; ?>
	  <div class="row">
		  <div class="field">
<!--		    --><?//=$data['name'] ?>
		    <?=$fieldName;?></div>
		  :
			 <? include ROOT . '/app/view/components/CustomCatalogItem/value.php' ?>
	  </div>

	<? endforeach; ?>
	<? include ROOT . '/app/view/components/CustomCatalogItem/buttons.php' ?>

</div>



