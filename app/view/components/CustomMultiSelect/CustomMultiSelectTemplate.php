<select
		multiple="true"
		custom-select
		data-field="<?= $model->field; ?>"
	<?= $model->title ? "data-title=" . $model->title : ''; ?>
	<?= $model->selectClassName ? "class=" . $model->selectClassName : ''; ?>
>

	<? if ($model->initialOption): ?>
	  <option value=""><?= $model->initialOptionValue; ?></option>
	<? endif; ?>

	<? foreach ($model->tree as $k => $v): ?>

	  <option value="<?= $v['id'] ?>">
			 <?= $v[$model->nameFieldName] ?>
	  </option>
		<? $level = 0; ?>
		<? if (isset($v['childs'])): ?>
			<?= $model->getChilds($v['childs'], $level); ?>
		<? endif ?>

	<? endforeach; ?>


</select>


