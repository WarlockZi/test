<div class="test-edit-wrapper">
	<?$t=$test['isTest']?true:false?>
	<? include ROOT . '/app/view/Test/edit_menu.php' ?>

	<div class="test-edit__content">
		<div class="test-name">Изменение <?=$t?'теста':'папки'?></div>
		<div class="test-path-add__table">
			<div>Название <?=$t?'теста':'папки'?></div>
			<div id="test_name" class="field" contenteditable="true"><?= $test['test_name'] ?></div>
			<div>Папка</div>

			<select>
				<option value='0'></option>
				<? foreach ($rootTests as $rootTest): ?>
					<option value=<?= $rootTest['id'] ?>
					<?=$rootTest['id']===$test['parent']?'selected':'';?>>
						<?= $rootTest['test_name'] ?>
					</option>
				<? endforeach; ?>
			</select>

			<label for="enable">Показыать пользователям</label>
			<input id="enable" type="checkbox" <?= $test['enable'] ? 'checked' : ''; ?>>

		<div class="test__save">Сохранить</div>
		<div class="test__delete">Удалить</div>
		</div>

	</div>
</div>

