<div custom-list
	<?= $this->class; ?>
	<?= $this->relation; ?>
	<?= $this->model; ?>
>

	<?= $this->pageTitle; ?>

	<div class="custom-list"
		 <?= $this->grid ?>
	>

		<!--  HEADER  -->
		 <? foreach ($this->columns as $c): ?>
		  <div
				  <?= $c->classHeader; ?>
					<?= $c->type; ?>
					<?= $c->sort; ?>
		  >
					<?= $c->sortIcon; ?>
					<?= $c->name; ?>
					<?= $c->search; ?>
		  </div>
		 <? endforeach; ?>

		<!--  TABLE  -->

		<!--		 Empty row-->
		 <?= $this->emptyRow(); ?>

		<!--		 Data rows-->
		 <? foreach ($this->items as $item): ?>

			 <? foreach ($this->columns as $field => $c): ?>

				 <? if ($c->html): ?>
					 <?= $c->html ?>
				 <? else: ?>

				  <div

								<?= $this->getId($item['id']); ?>
								<?= $c->dataField; ?>
								<?= $c->class; ?>
								<?= $c->contenteditable; ?>
				  ><?= $this->getData($c, $item, $field); ?></div>
				 <? endif; ?>

			 <? endforeach; ?>

		 <? endforeach; ?>

	</div>

	<!--  ADD BUTTON  -->
	<div class="buttons">
		 <? include ROOT . '/app/view/components/Builders/ListBuilder/add.php'; ?>
	</div>


</div>
