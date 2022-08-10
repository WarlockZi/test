<div class="item_header">

	<div class="page-title"><?= $this->pageTitle ?? ''; ?></div>

</div>

<div class="item_content">

	<!--  TABLE  -->
	<? foreach ($this->fields as $field): ?>
	  <div class="row">
		  <div class="field"><?= $field->name; ?></div>
		  :
			 <? include ROOT . '/app/view/components/Builders/ItemBuilder/value.php' ?>
	  </div>

	<? endforeach; ?>
	<? include ROOT . '/app/view/components/Builders/ItemBuilder/buttons.php' ?>

</div>



