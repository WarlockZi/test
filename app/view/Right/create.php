<div class="adm-content">

	<div class="page-name">Права</div>

	<div class="rights-table">

		<div class="id head">ID</div>
		<div class="name head">Наименование</div>
		<div class="description head">Описание</div>
		<div class="head"></div>
		<div class="head"></div>


		<? foreach ($rights as $right): ?>
			<? $data = 'data-id=' . $right['id']; ?>

			<div <?= $data ?> class="id"><?= $right['id'] ?></div>
			<div <?= $data ?> class="name" contenteditable><?= $right['name'] ?></div>
			<div <?= $data ?> class="description" contenteditable><?= $right['description'] ?></div>
			<div <?= $data ?> class="save">
				<? include SAVE; ?>
			</div>
			<div <?= $data ?> class="del">
				<? include TRASH; ?>
			</div>

		<? endforeach; ?>

		<div data-id="new" class="id"></div>
		<div data-id="new" class="name" contenteditable></div>
		<div data-id="new" class="description" contenteditable></div>
		<div data-id="new" class="save"><? include SAVE; ?></div>
		<div data-id="new" class="del"></div>

	</div>


</div>