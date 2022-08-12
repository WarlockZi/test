<div class="custom-list__wrapper"
	<?= $this->dataModel; ?>
	<?= $this->morph; ?>
	<?= $this->morphId; ?>
	<?= $this->parent; ?>
	<?= $this->parentId; ?>
>
	<div class="list-title"><?= $this->pageTitle; ?></div>

	<div class="custom-list"
		 <?= $this->grid ?>
	>

		<!--  HEADER  -->
		 <? foreach ($this->columns as $c): ?>
		  <div
				  class="head <?= $c->class; ?>"
					<?= $c->type; ?>
					<?= $c->sort; ?>
		  >
					<?= $c->sortIcon; ?>
					<?= $c->name; ?>
					<?= $c->search; ?>
		  </div>
		 <? endforeach; ?>

		 <?= ($this->headEditCol); ?>

		 <?= ($this->headDelCol); ?>

		<!--  TABLE  -->
		<!--		 Empty row-->
		 <?= $this->emptyRow(); ?>

		<!--		 Data rows-->
		 <? foreach ($this->items as $item): ?>

			 <? foreach ($this->columns as $field => $c): ?>

			  <div
						 <?= $this->dataModel; ?>
					  data-id="<?= $item['id']; ?>"
						 <?= $c->dataField; ?>
						 <?= $c->class; ?>
						 <?= $c->contenteditable; ?>
			  ><?= $item[$field]; ?></div>

			 <? endforeach; ?>

			 <?= $this->getEditButton($item['id']); ?>
			 <?= $this->getDelButton($item['id']); ?>

		 <? endforeach; ?>

	</div>

	<!--  ADD BUTTON  -->
	<div class="custom-list__buttons">
		 <? include ROOT . '/app/view/components/Builders/ListBuilder/add.php'; ?>
	</div>


</div>
