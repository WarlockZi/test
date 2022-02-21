<div class="custom-list <?= $this->tableClassName ?>"
     style="display: grid;<?= $this->grid ?>">


	<? foreach ($this->columns as $i): ?>
		<? $class = $i['className'] ?? '';
		$search = $i['search'] ? $this->searchStr : '';
		?>
	  <div class="head <?= $class ?>"><?= $i['name'] ?> <?= $search ?></div>
	<? endforeach; ?>

	<div class='head edit'><? include EDIT ?></div>
	<div class='head del'><? include TRASH ?></div>


	<? foreach ($this->model as $model): ?>

		<? foreach ($this->columns as $column): ?>
			<? if (isset($column['concat'])): ?>
				<? $value = $this->concatArray($column,$model)  ?>

			<? endif; ?>
		  <div class="<?= $column['className']; ?>" data-id="<?= $model['id']; ?>"><?= $value ?></div>

		<? endforeach; ?>


	  <!--	--><? // if (array_key_exists($model, $this->columns)): ?>
	  <!---->
	  <!--	--><? // endif; ?>


	  <!--	<div class="fio">-->
	  <!---->
	  <!--		 --><? // //= $model['surName']; ?><!---->
		<? // //= $model['name']; ?><!----><? // //= $model['middleName']; ?>
	  <!---->
	  <!--	</div>-->
	  <!--	<div class="email">--><? // //= $model['email']; ?><!--</div>-->
	  <!--	<div class="confirmed">--><? // //= $model['confirm']; ?><!--</div>-->

	  <div class="edit">
		  <a href="/adminsc/crm/user?id=<?= $model['id']; ?>">
					<? include EDIT; ?>
		  </a>
	  </div>

	  <div class="del">
		  <a href="/adminsc/crm/user/delete?id=<?= $model['id']; ?>">
					<? include TRASH ?>
		  </a>
	  </div>

	<? endforeach; ?>


</div>