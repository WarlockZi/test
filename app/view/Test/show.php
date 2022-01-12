<div class="test-edit-wrapper">

	<!--	--><? // include ROOT . '/app/view/Test/edit_menu.php' ?>
	<? include ROOT . '/app/view/Test/edit_accordion.php' ?>
	<div class="test-edit__content">
		<div class="test-name">Добавление <?= $test['isTest'] ? 'теста' : 'папки' ?></div>

		<div class="test-path-add__table">


			<div class="test-update__group">
<!--				<div class="test-path-add__th">Название --><?//= $test['isTest'] ? 'теста' : 'папки' ?><!--</div>-->
				<div class="centered">
					<div class="group">
						<input type="text" class="field" id="test_name" value="" required>
						<label for="test_name">Название <?= $test['isTest'] ? 'теста' : 'папки' ?></label>
						<!--				<div class="bar"></div>-->
					</div>
				</div>
			</div>


			<!--			<div id="test_name" class="field" contenteditable="true"></div>-->
			<div class="test-update__group">
				<div class="test-path-add__th">Прикрепить к группе</div>
				<select>
					<option value='0'></option>
					<? foreach ($rootTests as $rootTest): ?>
						<option value=<?= $rootTest['id'] ?>><?= $rootTest['test_name'] ?></option>
					<? endforeach; ?>
				</select>
			</div>


			<div class="test-update__group">
				<label class="test-path-add__th" for="enable">Показыать пользователям</label>
				<input id="enable" type="checkbox">
			</div>


		</div>
		<input type="hidden" isTest="<?= $test['isTest'] ?>">
		<div class="<?= $test['isTest'] ? 'test__create' : 'test-path__create' ?>">Сохранить</div>
	</div>


</div>