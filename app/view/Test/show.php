<section>
	<h1>Добавление теста</h1>
	<div class="grid">
		<div >Название теста</div>
		<div id="test_name" class="field" contenteditable="true"></div>
		<div>Группа</div>

		<select>
			<option value='0'></option>
			<? foreach ($rootTests as $test): ?>
				<option value=<?= $test['id'] ?>><?= $test['test_name'] ?></option>
			<? endforeach; ?>
		</select>
		<label for="isPath">Сделать папкой</label>
		<input id="isPath" type = "checkbox">
		<label for="enable">Показыать пользователям</label>
		<input id="enable" type = "checkbox">

	</div>
		<div class="save-test">Сохранить</div>


<!--	<div class="row">-->
<!--		<div>Название теста</div>-->
<!--		<div class="field" contenteditable="true"></div>-->
<!--	</div>-->
<!--	<div class="row">-->
<!--		<div>Группа</div>-->
<!--		<select>-->
<!--			<option value='0'></option>-->
<!--			--><?// foreach ($rootTests as $test): ?>
<!--				<option value=--><?//= $test['id'] ?>
	<!--<?//= $test['test_name'] ?></option>-->
<!--			--><?// endforeach; ?>
<!--	</div>-->
<!--	<div class="row">-->
<!--		<div>Сохранить</div>-->
<!--	</div>-->


</section>