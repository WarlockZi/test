<div class="adm-content">
	<div class="user-table">
		<div class="user head">
			<div class="id">ID</div>
			<div class="fio">фио</div>
			<div class="email">email</div>
			<div class="confirmed">co</div>
			<div>Save</div>
			<div>Delete</div>
		</div>

		<? foreach ($users as $use): ?>
			<div class="user">
				<div class="id"><?= $use['id'] ?></div>
				<a class="fio"
				   href="/adminsc/crm/user?id=<?= $use['id']; ?>"><?= $use['surName']; ?> <?= $use['name']; ?> <?= $use['middleName']; ?></a>
				<div class="email" contenteditable><?= $use['email']; ?></div>
				<div class="confirmed" contenteditable><?= $use['confirm']; ?></div>
				<div class="save">Save</div>
				<div class="del">Delete</div>
			</div>

		<? endforeach; ?>

		<div class="user">
			<div class="id"></div>
			<div class="fio" contenteditable></div>
			<div class="email" contenteditable></div>
			<div class="confirmed" contenteditable></div>
			<div class="save">Save</div>
			<div class="del">Delete</div>
		</div>
	</div>


</div>
