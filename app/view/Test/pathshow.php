<section>
	<h1>Добавление группы тестов</h1>
	<div class="test-path-add__table">
		<div >Название группы тестов</div>
		<div id="test_name" class="field" contenteditable="true"></div>

		<div>Прикрепить к группе</div>
		<select>
			<option value='0'></option>
			<? foreach ($rootTests as $rootTest): ?>
				<option value=<?= $rootTest['id'] ?>><?= $rootTest['test_name'] ?></option>
			<? endforeach; ?>
		</select>

<!--		<label for="isPath">Сделать папкой</label>-->
<!--		<input id="isPath" type = "checkbox">-->

		<label for="enable">Показыать пользователям</label>
		<input id="enable" type = "checkbox">

	</div>
		<div class="test-path__create">Сохранить</div>



</section>