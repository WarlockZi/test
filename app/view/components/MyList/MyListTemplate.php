<div class="custom-list__wrapper"
     data-model="<?= $this->model->model ?>"
	<?= $this->parent ? "data-parent='{$this->parent}'" : ''; ?>
	<?= $this->parentId ? "data-parent-id={$this->parentId}" : ''; ?>
>

	<div class="custom-list"
	     style="display: grid;<?= $this->grid ?>">

		<!--  HEADER  -->
		 <? foreach ($this->columns as $i): ?>
			 <?
			 $search = $i['search'] ? $this->getSearchString() : '';
			 $sort = $i['sort'] ? 'data-sort' : '';
			 ?>
		  <div
				  class="head <?= $i['className'] ?? '' ?>"
				  data-type="<?= $i['data-type'] ?? 'string' ?>"
					<?= $sort ?>>
					<?= $i['name'] ?> <?= $search ?>
		  </div>
		 <? endforeach; ?>

		 <? if ($this->editCol): ?>
		  <div class='head edit'><? include EDIT ?></div>
		 <? endif; ?>
		 <? if ($this->delCol): ?>
		  <div class='head del'><? include TRASH ?></div>
		 <? endif; ?>


		<!--  TABLE  -->
		<!--		 Empty row-->
		 <?= $this->emptyRow($this->columns); ?>

		<!--		 Data rows-->
		 <? foreach ($this->items as $model): ?>

			 <? foreach ($this->columns as $field => $column): ?>

			  <div
					  class="<?= $column['class'] ? $column['class'] : $field; ?>"
					  data-field="<?= $field; ?>"
					  data-model="<?= $this->model->model; ?>"
					  data-id="<?= $model['id']; ?>"
						 <?= $column['contenteditable'] ? 'contenteditable' : ''; ?>
			  ><?= $model[$field]; ?></div>

			 <? endforeach; ?>

			 <?= $this->getEditButton($model, $field, $column); ?>
			 <?= $this->getDelButton($model, $field, $column); ?>

		 <? endforeach; ?>

	</div>

	<!--  ADD BUTTON  -->
	<div class="custom-list__buttons">
		 <? include ROOT . '/app/view/components/MyList/add.php'; ?>
	</div>


</div>
