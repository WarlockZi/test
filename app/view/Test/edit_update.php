<div class="test-edit-wrapper">
	<? $t = $test['isTest'] ? true : false ?>


	<div class='test-edit__accordion'>
		<? include ROOT . '/app/view/Test/edit_accordion.php' ?>

		<? include ROOT . '/app/view/Test/add-test__button.php' ?>
	</div>


	<div class="test-edit__content">

		<div class="test-edit__menu-toggle">Выбрать тест</div>

		<div class="test-name">Изменение <?= $t ? 'теста' : 'папки' ?></div>


		<div class="centered">
			<div class="group">
				<input type="text" class="field" id="test_name" value="<?= htmlspecialchars($test['test_name'])?>" required>
				<label for="test_name">Название</label>
			</div>
		</div>

		<div class="select">
			<!--			<button type="button" class="select__toggle" name="car" value="" data-select="toggle" data-index="-1">Выберите из списка</button>-->
			<!--			<div class="select__dropdown">-->
			<!--				<ul class="elect__options">-->
			<!--					<li class="elect__option" data-select="option" data-value="volkswagen" data-index="0">Volkswagen</li>-->
			<!--					<li class="elect__option elect__option_selected" data-select="option" data-value="ford" data-index="1">Ford</li>-->
			<!--					<li class="elect__option" data-select="option" data-value="toyota" data-index="2">Toyota</li>-->
			<!--				</ul>-->
			<!--			</div>-->
		</div>


		<div class="test-path-add__table">


			<div class="test-update__group">
				<div class="test-path-add__th">Папка</div>
				<select>
					<option value='0'></option>
					<? foreach ($rootTests as $rootTest): ?>
						<option value=<?= $rootTest['id'] ?>
							<?= $rootTest['id'] === $test['parent'] ? 'selected' : ''; ?>>
							<?= $rootTest['test_name'] ?>
						</option>
					<? endforeach; ?>
				</select>
			</div>

			<div class="test-update__group">
				<label class="test-path-add__th" for="enable">Показыать пользователям</label>
				<input id="enable" type="checkbox" <?= $test['enable'] ? 'checked' : ''; ?>>
			</div>

			<div class="test-update__group">
				<div class="test-path-add__th">Содержит Тесты и Папки</div>
				<div class="children">
					<? if (isset($test['children']) && $test['children']): ?>
						<? foreach ($test['children'] as $child): ?>
							<div class="test-edit__child">> <?= $child['test_name'] ?></div>
						<? endforeach; ?>
					<? else: ?>
						<div>не содержит</div>
					<? endif; ?>
				</div>
			</div>

			<input type="hidden" isTest="<?= $test['isTest'] ?>">

			<div class="test-update__buttons">
				<div class="<?= $test['isTest'] ? 'test__update' : 'test-path__update' ?>">Сохранить</div>
				<div class="test__delete">Удалить</div>
			</div>
		</div>

	</div>
</div>

