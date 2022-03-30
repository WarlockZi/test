<select
  <?= $model->js; ?>
  data-title="<?=$model->title??'';?>"
  data-value=""
  class="<?= $model->selectClassName; ?>"

	<? if ($model->initialOption): ?>
	  <option value=""><?= $model->initialOptionValue; ?></option>
	<? endif; ?>

	<? foreach ($model->tree as $k => $v): ?>

	  <option value="<?= $v['id'] ?>">
			 <?= $model->initialTab ? $model->tab : ''; ?><?= $v['test_name'] ?>
	  </option>
		<? $level = 0; ?>
		<? if (isset($v['childs'])): ?>
			<?= $model->getChilds($v['childs'], $level); ?>
		<? endif ?>

	<? endforeach; ?>


</select>


