<div multi-select
<?= $this->className ? "class='{$this->className}'" :""; ?>"
     data-field="<?= $this->field; ?>"
	<?= $this->title ? "title='{$this->title}'" : ''; ?>
     tabindex="0"

>
	<div class="wrap">
		<div class="chip-wrap">
				<? foreach ($this->tree as $k => $v): ?>
					<? if (in_array($v['id'], $this->selected)): ?>
				  <div class="chip" data-id="<?= $v['id']; ?>"><?= $v[$this->fieldName] ?>
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
					 <? foreach ($this->tree as $k => $v): ?>
				  <label for="<?= $v[$this->fieldName] ?>"
				         data-id="<?= $v['id']; ?>"
								<?= in_array($v['id'], $this->selected)
									? "class='selected'" : ''; ?>
				  ><?= $v[$this->fieldName] ?></label>
					 <? endforeach; ?>
			</li>
		</ul>

		<select multiple="true" >

				<? foreach ($this->tree as $k => $v): ?>
			  <option
					  value="<?= $v['id'] ?>"
						 <?= in_array($v['id'], $this->selected) ? 'selected' : ''; ?>
			  ><?= $v[$this->fieldName] ?>
			  </option>
					<? $level = 0; ?>
					<? if (isset($v['childs'])): ?>
						<?= $this->getChilds($v['childs'], $level); ?>
					<? endif ?>

				<? endforeach; ?>


		</select>

	</div>
</div>
