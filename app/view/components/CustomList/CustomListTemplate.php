<div class="custom-list__wrapper">

	<div class="custom-list"
	     data-table="<?= $this->tableClassName ?>"
	     data-model="<?= $this->modelName ?>"
	     style="display: grid;<?= $this->grid ?>">

		<!--  HEADER  -->
		 <? foreach ($this->columns as $i): ?>
			 <?
			 $search = $i['search'] ? $this->searchStr : '';
			 ?>
		  <div class="head
	  <?= $i['className'] ?? '' ?>"
		       data-type="<?= $i['data-type'] ?>"
		  >
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
			       data-id="<?= $model['id']; ?>"
						 <?= $column['contenteditable'] ?? ''; ?>
			  ><?= $this->prepareData($column, $model); ?></div>

			 <? endforeach; ?>

			 <? if ($this->editCol == 'ajax'): ?>
			  <div class="edit" data-id="<?= $model['id']; ?>">
				  <div data-id="<?= $model['id']; ?>">
								<? include EDIT; ?>
				  </div>
			  </div>
			 <? elseif ($this->editCol == 'redirect'): ?>
			  <div class="edit" data-id="<?= $model['id']; ?>">
				  <a href="/adminsc/<?= $this->modelName; ?>/edit/<?= $model['id']; ?>">
								<? include EDIT; ?>
				  </a>
			  </div>
			 <? endif; ?>

		  <div class="del" data-id="<?= $model['id']; ?>">
					<? if ($this->delCol == 'ajax'): ?>
				 <div data-id="<?= $model['id']; ?>">
							 <? include TRASH; ?>
				 </div>
					<? elseif ($this->delCol == 'redirect'): ?>
				 <a href="/adminsc/<?= $this->modelName; ?>/delete/<?= $model['id']; ?>">
							 <? include TRASH ?>
				 </a>
					<? endif; ?>

		  </div>

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
	     data-model="<?= $this->modelName; ?>">+</a>
	<? endif; ?>


</div>
