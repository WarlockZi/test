<div class="test-edit__content">


	<? if ($test): ?>

		<div class="test-edit__menu-toggle">Выбрать тест</div>


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
					<? include ROOT . '/app/view/Test/edit_BlockQuestion.php' ?>
					<? $question__create = false; $i=1;?>
				</div>

				<div class="answer__create">

					<? include ROOT . '/app/view/Test/edit_BlockAnswer.php' ?>
				</div>

				<? if ($testDataToEdit): ?>
					<? foreach ($testDataToEdit as $q_id => $block): ?>
						<? include ROOT . '/app/view/Test/edit_BlockQuestion.php' ?>
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
			<?= include ROOT . '/app/view/Test/edit_children.php' ?>
		<? endif; ?>

		<div class="rules">
			<BR>
			<BR>
			<BR>
			<h1>Правила написания тестов</h1>
			<p>Одна глава инструкции - один тест</p>
			<p>Правильный ответ по объему должен быть примерно
				равным неправильным. Чтобы не было понятно,
				что это правильный ответ</p>

			<h3>Изменение последовательности вопросов</h3>
			<p>- навести курсор на номер вопроса. Появится значок перекрестия</p>
			<p>- зажав левую кнопку мыши, перетащить вопрос на нужное место</p>

			<h3>Добавить тест</h3>
			<p>- нажать Выбрать тест</p>
			<p>- навести курсор на кнопку Добавить</p>
			<p>- выбрать пункт Добавить тест</p>

			<h3>Добавить папку</h3>
			<p>- нажать Выбрать тест</p>
			<p>- навести курсор на кнопку Добавить</p>
			<p>- выбрать пункт Добавить папку</p>

			<h3>Переместить вопрос с ответами в другой тест</h3>
			<p>- нажать в строке с вопросом галку</p>
			<p>откроется список тестов</p>
			<p>- выбрать тест, куда перенести</p>

		</div>


	<? else: ?>

		<div class="test-edit__menu-toggle">Выбрать тест</div>
<!--		<h1>Выберите тест</h1>-->

	<? endif; ?>

</div>
