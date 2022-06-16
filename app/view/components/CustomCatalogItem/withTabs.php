<div class="item_header">

	<div class="page-title"><?= $this->pageTitle ?></div>
	<? include ROOT . '/app/view/components/CustomCatalogItem/tabs.php' ?>
</div>


<div class="item_content">

	<section class="show" data-id="1">

		<!--  TABLE  -->
		 <? foreach ($this->fields as $fieldName => $data): ?>
		  <div class="row">
			  <div class="field"><?= $data['name'] ?></div>
			  :
					<? include ROOT . '/app/view/components/CustomCatalogItem/value.php' ?>

		  </div>
		 <? endforeach; ?>
	</section>


	<? $n = 2; ?>
	<? foreach ($this->tabs as $k => $tab): ?>
	  <section
			  tab
			  data-field="<?= $tab['field']; ?>"
			  data-type="inputs"
			  data-id=<?= $n ?>>
			 <?= $tab['html']; ?>
	  </section>
		<? $n++; ?>
	<? endforeach; ?>

	<!--	<div class="buttons_wrap">-->
	<? include ROOT . '/app/view/components/CustomCatalogItem/buttons.php' ?>
	<!--	</div>-->

</div>
