<section class="test-do">

	<? include ROOT . '/app/view/Test/test_head.php'; ?>

	<div class="content">

		 <?= $test->getAccordion(); ?>

		<div class="test">

				<?= $test->getPagination(); ?>
				<?= $test->getContent(); ?>

		</div>

</section>

