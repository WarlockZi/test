<section class="test-do">

	<? include ROOT . '/app/view/Test/test-head.php'; ?>

	<div class="content">
		 <? include ROOT . '/app/view/components/test/test_do_accordion.php'; ?>

		 <? if ($test): ?>
			 <? include ROOT . '/app/view/Test/do_content.php'; ?>
		 <? else: ?>
		  <h2>Выберите тест</h2>
		 <? endif; ?>

</section>
