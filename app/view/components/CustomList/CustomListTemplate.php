<div class="custom-list__wrapper"
     data-model="<?= $this->modelName ?>"
     data-table="<?= $this->tableClassName ?>"
     data-filter="<?= $this->filter ?>"
>

	<div class="custom-list"
	     style="display: grid;<?= $this->grid ?>">

		<!--  HEADER  -->
		 <? foreach ($this->columns as $i): ?>
			 <?
			 $search = $i['search'] ? $this->searchStr : '';
			 $sort = $i['sort'] ? 'data-sort' : '';
			 ?>
		  <div class="head <?= $i['className'] ?? '' ?>"
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
		 <? foreach ($this->models as $model): ?>

			 <? foreach ($this->columns as $field => $column): ?>

			  <div class="<?= $column['className']; ?>"
			       data-field="<?= $field; ?>"
			       data-id="<?= $model['id']; ?>"
						 <?= $column['contenteditable'] ?? ''; ?>
			  ><?= $this->prepareData($column, $model); ?></div>

			 <? endforeach; ?>

			 <? include ROOT . '/app/view/components/CustomList/edit.php'; ?>

			 <? include ROOT . '/app/view/components/CustomList/del.php'; ?>


		 <? endforeach; ?>

	</div>

	<!--  ADD BUTTON  -->
	<div class="custom-list__buttons">

			 <? include ROOT . '/app/view/components/CustomList/add.php'; ?>
	</div>


</div>
