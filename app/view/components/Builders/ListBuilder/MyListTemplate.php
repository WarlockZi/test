<div class="custom-list__wrapper"
	<?= $this->dataModel; ?>
	<?= $this->morph; ?>
	<?= $this->morphId; ?>
	<?= $this->parent; ?>
	<?= $this->parentId; ?>
>

	<div class="custom-list"
		 <?= $this->grid ?>>

		<!--  HEADER  -->
		 <? foreach ($this->columns as $i): ?>
		  <div
				  class="head <?= $i['class']; ?>"
				  data-type="<?= $i['type']; ?>"
					<?= $i['sort']; ?>>
					<?= $i['name']; ?>
					<?= $i['search']; ?>
		  </div>
		 <? endforeach; ?>

		 <?= ($this->headEditCol); ?>

		 <?= ($this->headDelCol); ?>

		<!--  TABLE  -->
		<!--		 Empty row-->
		 <?= $this->emptyRow(); ?>

		<!--		 Data rows-->
		 <? foreach ($this->items as $item): ?>

			 <? foreach ($this->columns as $field => $data): ?>

			  <div
						 <?= $this->dataModel; ?>
					  data-id="<?= $item['id']; ?>"
						 <?= $data['dataField']; ?>
						 <?= $data['class']; ?>
						 <?= $data['contenteditable'] ? 'contenteditable' : ''; ?>
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
