<? if ($this->addButton === 'ajax'): ?>

	<div class="add-model">+</div>

<? elseif ($this->addButton === 'redirect'): ?>
	<a href="/adminsc/<?= $this->modelName ?>/show"
	   class="add-model">+
	</a>
<? endif; ?>
