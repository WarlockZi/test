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
				<input type="text" class="field" id="test_name" value="<?= htmlspecialchars($test['test_name']) ?>"
				       required>
				<label for="test_name">Название</label>
			</div>
		</div>

		<select data-custom-parent>
			<option value="-1"></option>
			<? foreach ($paths as $parent): ?>
				<option
						value="<?= $parent['id'] ?>"
					<?= $test['parent'] === $parent['id'] ? 'selected' : ''; ?>
				>
					<?= $parent['test_name'] ?>
				</option>
			<? endforeach; ?>
		</select>

		<select data-custom-enable>
			<option value="-1"> </option>
			<option value="1"
				<?= $test['enable'] ? 'selected' : ''; ?>
			>да
			</option>
			<option value="0"
				<?= $test['enable'] ? 'selected' : ''; ?>
			>нет
			</option>
		</select>


<!--		<div class="test-update__group">-->
<!--			<div class="test-path-add__th">Содержит Тесты и Папки</div>-->
<!--			<div class="children">-->
<!--				--><?// if (isset($test['children']) && $test['children']): ?>
<!--					--><?// foreach ($test['children'] as $child): ?>
<!--						<div class="test-edit__child">- --><?//= $child['test_name'] ?><!--</div>-->
<!--					--><?// endforeach; ?>
<!--				--><?// else: ?>
<!--					<div>не содержит</div>-->
<!--				--><?// endif; ?>
<!--			</div>-->
<!--		</div>-->

		<input type="hidden" isTest="<?= $test['isTest'] ?>">

		<div class="test-update__buttons">
			<div class="<?= $test['isTest'] ? 'test__update' : 'test-path__update' ?>">Сохранить</div>
			<div class="test__delete">Удалить</div>
		</div>
	</div>

</div>

