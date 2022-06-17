<div class="content">

	<div class="navigation">
		<div class='pagination__wrap'>
			<div class='test-name' data-test-id=<?= $test['id']; ?>><?= $test['name']; ?></div>
				<?= $pagination; ?>
		</div>
	</div>


	<? if ($testData): ?>

		<? include ROOT . '/app/view/Test/do_test-data.php'; ?>

	<? else: ?>
	  <h2>Пока нет вопросов</h2>
	<? endif; ?>

</div>



