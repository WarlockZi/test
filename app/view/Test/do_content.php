<div class="test">

	<div class="navigation">
		<div class='test-name' data-test-id=<?= $test['id']; ?>><?= $test['name']; ?></div>
		 <?= $pagination; ?>
	</div>


	<? if ($testData): ?>
		<? include ROOT . '/app/view/Test/do_test-data.php'; ?>
	<? else: ?>
	  <h2>Пока нет вопросов</h2>
	<? endif; ?>

</div>



