<div class="multiselect" tabindex="0">
	<div class="wrap">
		<div class="chip-wrap">
				<? foreach ($model->tree as $k => $v): ?>

			  <div class="chip" data-id="<?= $v['id']; ?>"><?= $v[$model->fieldName] ?>
				  <div class="del">Х</div>
			  </div>

				<? endforeach; ?>
		</div>

		<div class="arrow">
				<? include ICONS . '/ArrowDropDownIcon.svg' ?>
		</div>

		<select
				multiple="true"
				custom-select
				data-field="<?= $model->field; ?>"
				<?= $model->title ? "title='{$model->title}'" : ''; ?>
				<?= $model->className ? "class={$model->className}" : ''; ?>

		>

				<? foreach ($model->tree as $k => $v): ?>

			  <option
					  value="<?= $v['id'] ?>"
						 <?= in_array($v['id'], $model->selected) ? 'selected' : ''; ?>
			  >
						 <?= $v[$model->fieldName] ?>
			  </option>
					<? $level = 0; ?>
					<? if (isset($v['childs'])): ?>
						<?= $model->getChilds($v['childs'], $level); ?>
					<? endif ?>

				<? endforeach; ?>


		</select>

	</div>

	<ul>
		<li class="inner">
				<? foreach ($model->tree as $k => $v): ?>
			  <label for="<?= $v[$model->fieldName] ?>"
			         data-id="<?= $v['id']; ?>"
						 <?= in_array($v['id'],$model->selected)
						   ?"class='selected'":''; ?>
			  ><?= $v[$model->fieldName] ?></label>
				<? endforeach; ?>
		</li>
	</ul>


</div>
