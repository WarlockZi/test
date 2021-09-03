<div class="test-edit-wrapper">
	<? include ROOT . '/app/view/Test/edit_menu.php' ?>

	<div class="test-edit__content">
		<div class="test-name">Добавление <?=$test['isTest']?'теста':'папки'?></div>
		<div class="test-path-add__table">
			<div>Название  <?=$test['isTest']?'теста':'папки'?></div>
			<div id="test_name" class="field" contenteditable="true"></div>
			<div>Прикрепить к группе</div>

			<select>
				<option value='0'></option>
				<? foreach ($rootTests as $rootTest): ?>
					<option value=<?= $rootTest['id'] ?>><?= $rootTest['test_name'] ?></option>
				<? endforeach; ?>
			</select>

			<label for="enable">Показыать пользователям</label>
			<input id="enable" type="checkbox">

		</div>
		<div class="test-path__create">Сохранить</div>
	</div>


</div>