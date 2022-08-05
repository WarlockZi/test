<div multi-select
     tabindex="0"
	<?= $this->class; ?>
	<?= $this->field; ?>
	<?= $this->model; ?>
	<?= $this->title; ?>

>
	<div class="wrap">
		<div class="chip-wrap">
				<? foreach ($this->items as $k => $v): ?>
					<? if (in_array($v['id'], $this->selected)): ?>
				  <div class="chip" data-id="<?= $v['id']; ?>"><?= $v[$this->optionName] ?>
					  <div class="del">Х</div>
				  </div>
					<? endif; ?>

				<? endforeach; ?>
		</div>

		<div class="arrow">
				<? include ICONS . '/ArrowDropDownIcon.svg' ?>
		</div>

		<ul>
			<li class="inner">
					 <? foreach ($this->items as $k => $v): ?>
						 <? if (!in_array($v['id'], $this->excluded)): ?>
					  <label for="<?= $v[$this->optionName] ?>"
					         data-id="<?= $v['id']; ?>"
									 <?= in_array($v['id'], $this->selected)
										 ? "class='selected'" : ''; ?>>
									 <?= $v[$this->optionName] ?>
					  </label>
						 <? endif; ?>
					 <? endforeach; ?>
			</li>
		</ul>

		<select multiple="true">

				<? foreach ($this->tree as $k => $v): ?>
			  <option
					  value="<?= $v['id'] ?>"
						 <?= in_array($v['id'], $this->selected) ? 'selected' : ''; ?>
			  ><?= $v[$this->optionName] ?>
			  </option>
					<? $level = 0; ?>
					<? if (isset($v['childs'])): ?>
						<?= $this->getChilds($v['childs'], $level); ?>
					<? endif ?>

				<? endforeach; ?>


		</select>

	</div>
</div>
