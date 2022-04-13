<select
		multiple="true"
<!--		custom-select-->
		data-field="<?= $model->field; ?>"
	<?= $model->title ? "title='{$model->title}'" : ''; ?>
	<?= $model->className ? "class={$model->className}" : ''; ?>

>

	<? foreach ($model->tree as $k => $v): ?>

	  <option
			  value="<?= $v['id'] ?>"
			  <?=in_array($v['id'],$model->selected)?'selected':'';?>
	  >
			 <?= $v[$model->fieldName] ?>
	  </option>
		<? $level = 0; ?>
		<? if (isset($v['childs'])): ?>
			<?= $model->getChilds($v['childs'], $level); ?>
		<? endif ?>

	<? endforeach; ?>


</select>


