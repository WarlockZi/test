<div class="test">
  <? if (isset($test)): ?>
    <? $title = "Пройти тест : {$test->name}"; ?>

		<div class="navigation">
			<div class='test-name' data-test-id=<?= $test->id ?? ''; ?>><?= $title; ?></div>
      <?= $pagination ?? ''; ?>
		</div>

    <? include ROOT . '/app/view/Test/do_test-data.php'; ?>

  <? else: ?>
		<h2>Выберите тест</h2>

  <? endif; ?>
</div>



