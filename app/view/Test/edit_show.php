<div class="test-edit-wrapper">

	<div class="page-name">Добавление <?= $test['isTest'] ? 'теста' : 'папки' ?></div>

	<div class="test-edit__cont">
		<div class='accordion_wrap'>
				<? include ROOT . '/app/view/Test/edit_accordion.php' ?>
		</div>

		<div class="test-edit__content">

			<div class="test-path-add__table">

				<div class="centered">
					<div class="group">
						<input type="text" class="field" id="test_name" value="" required>
						<label for="test_name">Название <?= $test['isTest'] ? 'теста' : 'папки' ?></label>
					</div>
				</div>


				<select custom-select data-field="parent">
					<option value="0" selected>-</option>
							<? foreach ($paths as $parent): ?>
					  <option value="<?= $parent['id'] ?>">
									 <?= $parent['test_name'] ?>
					  </option>
							<? endforeach; ?>
				</select>


				<select custom-select data-field="enable">
					<option value="-1" selected>-</option>
					<option value="1">да</option>
					<option value="0">нет</option>
				</select>


			</div>

			<input type="hidden" isTest="<?= $test['isTest'] ?>">
			<div class="<?= $test['isTest'] ? 'test__create' : 'test-path__create' ?>">Сохранить</div>
		</div>

	</div>


</div>