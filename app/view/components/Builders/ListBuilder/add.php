<?php if ($addButton === 'ajax'): ?>

	<div class="add-model">+</div>

<?php elseif ($addButton === 'redirect'): ?>
	<a href="/adminsc/<?= $modelName ?>/show"
	   class="add-model">+
	</a>
<?php endif; ?>
