<section>
	<h1>Добавление теста</h1>
	<div class="test-path-add__table">
		<div >Название теста</div>
		<div id="test_name" class="field" contenteditable="true"></div>
		<div>Группа</div>

		<select>
			<option value='0'></option>
			<? foreach ($rootTests as $rootTest): ?>
				<option value=<?= $rootTest['id'] ?>><?= $rootTest['test_name'] ?></option>
			<? endforeach; ?>
		</select>

		<label for="enable">Показыать пользователям</label>
		<input id="enable" type = "checkbox">

	</div>
		<div class="test-show__create">Сохранить</div>



</section>