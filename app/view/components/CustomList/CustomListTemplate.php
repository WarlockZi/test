<div class="custom-list__wrapper">

	<div class="custom-list"
	     data-table="<?= $this->tableClassName ?>"
	     data-model="<?= $this->modelName ?>"
	     style="display: grid;<?= $this->grid ?>">

		<!--  HEADER  -->
		 <? foreach ($this->columns as $i): ?>
			 <?
			 $search = $i['search'] ? $this->searchStr : '';
			 $sort = $i['sort'] ? 'data-sort' : '';
			 ?>
		  <div class="head <?= $i['className'] ?? '' ?>"
		       data-type="<?= $i['data-type'] ?>"
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

			 <? foreach ($this->columns as $column): ?>

			  <div class="<?= $column['className']; ?>"
			       data-field="<?= $column['field']; ?>"
			       data-id="<?= $model['id']; ?>"
						 <?= $column['contenteditable'] ?? ''; ?>
			  ><?= $this->prepareData($column, $model); ?></div>

			 <? endforeach; ?>

			 <? if ($this->editCol): ?>
				 <? include ROOT . '/app/view/components/CustomList/edit.php'; ?>
			 <? endif; ?>

			 <? if ($this->delCol): ?>
				 <? include ROOT . '/app/view/components/CustomList/del.php'; ?>
			 <? endif; ?>


		 <? endforeach; ?>

	</div>

	<!--  ADD BUTTON  -->
	<? if ($this->addButton === 'ajax'): ?>
	  <div class="add-model"
	       data-model="<?= $this->modelName; ?>">+
	  </div>
	<? elseif ($this->addButton === 'redirect'): ?>
	  <a href="/adminsc/{$this->modelName}/create"
	     class="add-model"
	     data-model="<?= $this->modelName; ?>">+
	  </a>
	<? endif; ?>


</div>
