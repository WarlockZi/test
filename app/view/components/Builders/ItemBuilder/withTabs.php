<div class="item_header">


	<? include ROOT . '/app/view/components/Builders/ItemBuilder/tabs.php' ?>
</div>

<div class="item_content">

	<section data-tab="1" class="show">

		<!--  TABLE  -->
		 <? foreach ($this->fields as $field): ?>
				 <?include ROOT.'/app/view/components/Builders/ItemBuilder/row.php'?>
		 <? endforeach; ?>
	</section>

	<? $n = 2; ?>
	<? foreach ($this->tabs as $k => $tab): ?>
	  <section

			 <?= $tab->field; ?>
			  data-tab=<?= $n ?>>
			 <?= $tab->html; ?>

	  </section>
		<? $n++; ?>
	<? endforeach; ?>

	<? include ROOT . '/app/view/components/Builders/ItemBuilder/buttons.php' ?>


</div>
