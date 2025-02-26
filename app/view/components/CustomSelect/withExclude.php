<? foreach ($this->tree as $k => $v): ?>

	<option value="<?= $v['id'] ?? $k; ?>"
		<?= (int)$this->selected == $k ? 'selected' : ''; ?>>
		<?= is_string($v) ? $v : $v[$this->optionName]; ?>
	</option>

	<? if (isset($v['childs'])): ?>
		<?= $this->getChilds($v['childs'], 0); ?>
	<? endif ?>
<? endforeach; ?>