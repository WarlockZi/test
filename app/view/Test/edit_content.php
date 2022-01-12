<div class="test-edit__content">

	<? if ($test): ?>

		<? if (isset($test['isTest']) && $test['isTest']): ?>
			<div class="test-edit__title">
				<? if (isset($test)): ?>
					<p class="test-name"
					   value="<?= $_REQUEST['id'] ?? $test['id'] ?>"><?= $_REQUEST['name'] ?? $test['test_name'] ?>
					</p>
				<? endif; ?>
			</div>

			<div class="questions">

				<div class="question__create">
					<? $question__create = true; ?>
					<? include ROOT . '/app/view/Test/editBlockQuestion.php' ?>
					<? $question__create = false; ?>
				</div>

				<div class="answer__create">
					<? include ROOT . '/app/view/Test/editBlockAnswer.php' ?>
				</div>

				<? if ($testDataToEdit): ?>
					<? foreach ($testDataToEdit as $q_id => $block): ?>
						<? include ROOT . '/app/view/Test/editBlockQuestion.php' ?>
					<? endforeach; ?>
				<? endif; ?>
				<div class="question__create-button" data-action-hover="Добавить вопрос">Добавить вопрос</div>
			</div>


		<? else: ?>
			<div class="test-edit__title">
				<? if (isset($test)): ?>
					<p class="test-name"
					   value="<?= $_REQUEST['id'] ?? $test['id'] ?>"><?= $_REQUEST['name'] ?? $test['test_name'] ?>
					</p>
				<? endif; ?>
			</div>
			<?= include ROOT . '/app/view/Test/test-edit-children.php' ?>
		<? endif; ?>

		<div class="rules">
			<BR>
			<BR>
			<BR>
			<h1 style = "color:red">Правила написания тестов</h1>
			<p>
				Одна глава инструкции - один тест
			</p>
			<p>
				Правильный ответ по объему должен быть примерно
				равным неправильным. Чтобы не было понятно,
				что это правильный ответ
			</p>
			<h3>Изменение последовательности вопросов</h3>
			<p>
				- навести курсор на номер вопроса. Появится значок перекрестия "Перетащить"
			</p>
			<p>
				- зажав левую кнопку мыши, перетащить вопрос на нужное место
			</p>

		</div>


	<? else: ?>

		<h1>Выберите тест</h1>

	<? endif; ?>

</div>
