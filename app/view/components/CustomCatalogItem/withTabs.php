<div class="custom-catalog-item__header">

	<div class="tabs__wrapper">
		 <? include ROOT . '/app/view/components/CustomCatalogItem/tabs.php' ?>
		<div class="page-title"><?= $this->pageTitle ?></div>
	</div>
</div>


<div class="custom-catalog-item__content">
	<!--CONTENT-->
	<section class="show" data-id="1">
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

		</div>
	</section>


	<? $n = 2; ?>
	<? foreach ($this->tabs as $k => $tab): ?>
	  <section tab data-field="" data-id=<?= $n ?>>
			 <?= $tab; ?>
	  </section>
		<? $n++; ?>
	<? endforeach; ?>

	<div class="buttons__wrapper">
		 <? include ROOT . '/app/view/components/CustomCatalogItem/buttons.php' ?>
	</div>

</div>
