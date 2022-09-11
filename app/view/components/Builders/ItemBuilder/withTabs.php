<div class="item_header">

	<div class="page-title"><?= $this->pageTitle ?></div>
	<? include ROOT . '/app/view/components/Builders/ItemBuilder/tabs.php' ?>
</div>

<div class="item_content">

	<section class="show" data-tab="1">

		<!--  TABLE  -->
		 <? foreach ($this->fields as $field): ?>
				 <?include ROOT.'/app/view/components/Builders/ItemBuilder/row.php'?>
		 <? endforeach; ?>
	</section>

	<? $n = 2; ?>
	<? foreach ($this->tabs as $k => $tab): ?>
	  <section
			 <?= $this->dataModel ?>
			 <?= $tab->field; ?>
			  data-tab=<?= $n ?>>
			 <?= $tab->html; ?>

	  </section>
		<? $n++; ?>
	<? endforeach; ?>

	<? include ROOT . '/app/view/components/Builders/ItemBuilder/buttons.php' ?>


</div>
