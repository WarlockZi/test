<div class="item_content">

	<!--  TABLE  -->
	<? foreach ($this->fields as $field): ?>
		<? include ROOT . '/app/view/components/Builders/ItemBuilder/row.php' ?>
	<? endforeach; ?>

	<? include ROOT . '/app/view/components/Builders/ItemBuilder/buttons.php' ?>

</div>



