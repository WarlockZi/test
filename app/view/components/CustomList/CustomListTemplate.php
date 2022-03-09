<div class="custom-list <?= $this->tableClassName ?>"
     style="display: grid;<?= $this->grid ?>">


	<? foreach ($this->columns as $i): ?>
		<?
		$search = $i['search'] ? $this->searchStr : '';
		?>
	  <div class="head
	  <?= $i['className'] ?? '' ?>"
	       data-type="<?=$i['data-type']?>"
	  >
			 <?= $i['name'] ?> <?= $search ?>
	  </div>
	<? endforeach; ?>

	<div class='head edit'><? include EDIT ?></div>
	<div class='head del'><? include TRASH ?></div>


	<? foreach ($this->models as $model): ?>

		<? foreach ($this->columns as $column): ?>

		  <div class="<?= $column['className']; ?>"
		       data-id="<?= $model['id']; ?>"><?= $this->prepareData($column, $model); ?></div>

		<? endforeach; ?>


	  <div class="edit" data-id="<?= $model['id']; ?>">
		  <a href="/adminsc/<?= $this->modelName; ?>/edit/<?= $model['id']; ?>">
					<? include EDIT; ?>
		  </a>
	  </div>

	  <div class="del" data-id="<?= $model['id']; ?>">
		  <a href="/adminsc/user/delete/<?= $model['id']; ?>">
					<? include TRASH ?>
		  </a>
	  </div>

	<? endforeach; ?>


</div>