<div class="test-edit-wrapper">

	<? include ROOT . '/app/view/Test/edit_accordion.php' ?>


	<div class="test-edit__content">
		<div class="test-name">Добавление <?= $test['isTest'] ? 'теста' : 'папки' ?></div>

		<div class="test-path-add__table">

				<div class="centered">
					<div class="group">
						<input type="text" class="field" id="test_name" value="" required>
						<label for="test_name">Название <?= $test['isTest'] ? 'теста' : 'папки' ?></label>
					</div>
				</div>

			<select data-custom-path>
				<option value="-1"></option>
				<? foreach ($paths as $path): ?>
					<option
							value="<?= $path['id'] ?>"

					>
						<?= $path['test_name'] ?>
					</option>
				<? endforeach; ?>
			</select>

			<select data-custom-activ>
				<option value="-1"></option>
				<option value="1"
				>да
				</option>
				<option value="0"
				>нет
				</option>
			</select>


<!--			<div class="test-update__group">-->
<!--				<label class="test-path-add__th" for="enable">Показывать пользователям</label>-->
<!--				<input id="enable" type="checkbox">-->
<!--			</div>-->

		</div>

		<input type="hidden" isTest="<?= $test['isTest'] ?>">
		<div class="<?= $test['isTest'] ? 'test__create' : 'test-path__create' ?>">Сохранить</div>

	</div>


</div>