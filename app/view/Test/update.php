<section class="test-edit__container">

	<h1>Изменение теста</h1>
	<div class="test-path-add__table">
		<div >Название теста</div>
		<div id="test_name" class="field" contenteditable="true"><?=$test['test_name']?></div>
		<div>Группа</div>

		<select>
			<option value='0'></option>
			<? foreach ($rootTests as $rootTest): ?>
				<option value=<?= $rootTest['id'] ?>><?= $rootTest['test_name'] ?></option>
			<? endforeach; ?>
		</select>

<!--		<label for="isPath">Сделать папкой</label>-->
<!--		<input id="isPath" type = "checkbox" --><?//=$test['isTest']?'checked':'';?>

		<label for="enable">Показыать пользователям</label>
		<input id="enable" type = "checkbox" <?=$test['enable']?'checked':'';?>>

	</div>
		<div class="test-update__save">Сохранить</div>


</section>