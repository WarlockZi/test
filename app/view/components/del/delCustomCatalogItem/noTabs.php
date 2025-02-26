<div class="item_header">
	<?= $this->pageTitle; ?>
</div>

<div class="item_content">

	<!--  TABLE  -->
	<? foreach ($this->fields as $data): ?>
	  <div class="row">
		  <div class="field">
					<?= $data['field']; ?></div>
		  :
			 <? include ROOT . '/app/view/components/MyItem/value.php' ?>
	  </div>

	<? endforeach; ?>
	<? include ROOT . '/app/view/components/MyItem/buttons.php' ?>

</div>



