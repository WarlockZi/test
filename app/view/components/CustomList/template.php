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



	<? foreach ($this->model as $i): ?>

	  <div class="id"><?= $i['id'] ?></div>
	  <div>
		  <a class="fio" href="/adminsc/crm/user?id=<?= $i['id']; ?>">
					<?= $i['surName']; ?> <?= $i['name']; ?> <?= $i['middleName']; ?>
		  </a>
	  </div>
	  <div class="email"><?= $i['email']; ?></div>
	  <div class="confirmed"><?= $i['confirm']; ?></div>

	  <div class="edit">
		  <a href="/adminsc/crm/user?id=<?= $i['id']; ?>">
					<? include EDIT; ?>
		  </a>
	  </div>

	  <div class="del">
		  <a href="/adminsc/crm/user/delete?id=<?= $i['id']; ?>">
					<? include TRASH ?>
		  </a>
	  </div>

	<? endforeach; ?>




</div>