<div class="test-edit__title">
	<? if (isset($test)): ?>
	  <p class="test-name"
	     value="<?= $_REQUEST['id'] ?? $test['id'] ?>">
	    <?= $_REQUEST['name'] ?? $test['name'] ?>
	  </p>
	<? endif; ?>
</div>

<? if (isset($test['children'])): ?>
	<div class="list">
		 <? foreach ($test['children'] as $child): ?>
		  <div class="path-child__row">
					<? include ROOT . '/app/view/components/icons/path.svg' ?>
			  <div><?= $child['name'] ?></div>
		  </div>
		 <? endforeach; ?>
	</div>
<? else: ?>
	<div class="no-test">
		В данной папке нет тестов
	</div>
<? endif; ?>