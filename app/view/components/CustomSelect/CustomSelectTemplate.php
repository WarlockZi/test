<select
  custom-select
  data-field="<?= $model->field; ?>"
  title="<?=$model->title?$model->title:'';?>"
  <?=$model->selectClassName?"class=".$model->selectClassName:'';?>
>

	<? if ($model->initialOption): ?>
	  <option value=""><?= $model->initialOptionValue; ?></option>
	<? endif; ?>

	<? foreach ($model->tree as $k => $v): ?>

	  <option value="<?= $v['id']??$k; ?>"
	  <?=$model->selected===$k?'selected':'';?>>
			 <?= $v[$model->nameFieldName]??$v ?>
	  </option>
		<? $level = 0; ?>
		<? if (isset($v['childs'])): ?>
			<?= $model->getChilds($v['childs'], $level); ?>
		<? endif ?>

	<? endforeach; ?>


</select>


