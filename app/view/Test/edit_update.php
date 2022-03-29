<div class="test-edit-wrapper">
	<? $t = $test['isTest'] ? true : false ?>


	<div class='test-edit__accordion'>
		<? include ROOT . '/app/view/Test/edit_accordion.php' ?>

		<? include ROOT . '/app/view/Test/edit_add-test-button.php' ?>
	</div>


	<div class="test-edit__content">

		<? include ROOT . '/app/view/Test/test-head.php'; ?>
<!--		--><?// include COMPONENTS."/test/menu_toggle.php";?>


		<div class="test-name">Изменение <?= $t ? 'теста' : 'папки' ?></div>


		<div class="centered">
			<div class="group">
				<input type="text" class="field" id="test_name" value="<?= htmlspecialchars($test['test_name']) ?>"
				       required>
				<label for="test_name">Название</label>
			</div>
		</div>

		<select data-custom-parent>
			<option value="0">-</option>
			<? foreach ($paths as $parent): ?>
				<option
						value="<?= $parent['id'] ?>"
					<?= $test['parent'] === $parent['id']
						? "selected"
						: ""; ?>
				>
					<?= $parent['test_name'] ?>
				</option>
			<? endforeach; ?>
		</select>

		<select data-custom-enable>
			<option value="-1">-</option>
			<option value="1"
				<?= $test['enable'] ? "selected" : ""; ?>
			>да
			</option>
			<option value="0"
				<?= $test['enable'] ? "" : "selected"; ?>
			>нет
			</option>
		</select>


		<input type="hidden" isTest="<?= $test['isTest'] ?>">

		<div class="test-update__buttons">
			<div class="<?= $test['isTest'] ? 'test__update' : 'test-path__update' ?>">Сохранить</div>
			<div class="test__delete">Удалить</div>
		</div>
	</div>

</div>

