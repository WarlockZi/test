<div class="test-edit-wrapper">
	<? $t = $test['isTest'] ? true : false ?>
	<!--	--><? // include ROOT . '/app/view/Test/edit_menu.php' ?>

	<div class='test-edit__accordion'>
		<!--	--><? // include ROOT . '/app/view/Test/edit_menu.php' ?>
		<? include ROOT . '/app/view/Test/edit_accordion.php' ?>

		<div class='test-edit-menu__add-bttn' href="/adminsc/test/show">Добавить
			<div class="test-edit-menu__add-bttn-wrap">
				<a href="/adminsc/test/show" class="test-edit-menu__add-bttn-test">Добавить тест</a>
				<a href="/adminsc/test/pathshow" class="test-edit-menu__add-bttn-path">Добавить папку</a>
			</div>
		</div>

	</div>


	<div class="test-edit__content">
		<div class="test-name">Изменение <?= $t ? 'теста' : 'папки' ?></div>
		<div class="test-path-add__table">
			<div>Название <?= $t ? 'теста' : 'папки' ?></div>
			<div id="test_name" class="field" contenteditable="true"><?= $test['test_name'] ?></div>
			<div>Папка</div>

			<select>
				<option value='0'></option>
				<? foreach ($rootTests as $rootTest): ?>
					<option value=<?= $rootTest['id'] ?>
						<?= $rootTest['id'] === $test['parent'] ? 'selected' : ''; ?>>
						<?= $rootTest['test_name'] ?>
					</option>
				<? endforeach; ?>
			</select>

			<label for="enable">Показыать пользователям</label>
			<input id="enable" type="checkbox" <?= $test['enable'] ? 'checked' : ''; ?>>

			<div>Содержит Тесты и Папки</div>
			<div class="children">
				<? if (isset($test['children']) && $test['children']): ?>
					<? foreach ($test['children'] as $child): ?>
						<div class="test-edit__child">> <?= $child['test_name'] ?></div>
					<? endforeach; ?>
				<? else: ?>
					<div>не содержит</div>
				<? endif; ?>
			</div>
			<input type="hidden" isTest="<?= $test['isTest'] ?>">
			<div class="<?= $test['isTest'] ? 'test__update' : 'test-path__update' ?>">Сохранить</div>
			<div class="test__delete">Удалить</div>
		</div>

	</div>
</div>

