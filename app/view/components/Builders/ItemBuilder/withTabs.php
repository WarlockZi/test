<div class="item_header">

	<div class="page-title"><?= $this->pageTitle ?></div>
	<? include ROOT . '/app/view/components/Builders/ItemBuilder/tabs.php' ?>
</div>

<div class="item_content">

	<section class="show" data-tab="1">

		<!--  TABLE  -->
		 <? foreach ($this->fields as $fieldName => $field): ?>
		  <div class="row">
			  <div class="field"><?= $field->name ?></div>
			  :
					<? include ROOT . '/app/view/components/Builders/ItemBuilder/value.php' ?>

		  </div>
		 <? endforeach; ?>
	</section>

	<? $n = 2; ?>
	<? foreach ($this->tabs as $k => $tab): ?>
	  <section
			  <?=$this->model?>
			  data-tab=<?= $n ?>>
			 <?= isset($tab['field']) ? "data-field={$tab['field']}": ''; ?>
			 <?= $tab['html'] ?? ''; ?>

	  </section>
		<? $n++; ?>
	<? endforeach; ?>

	<? include ROOT . '/app/view/components/Builders/ItemBuilder/buttons.php' ?>


</div>
