<section class="test-do">

	<? include ROOT . '/app/view/Test/test_head.php'; ?>

	<div class="content">
		<div class="accordion_wrap">

				<?= $test->getAccordion(); ?>
		</div>
		<!--				--><? // include ROOT . '/app/view/Test/test_do_accordion.php'; ?>

		 <? include ROOT . '/app/view/Test/Admin/do_content.php'; ?>

</section>

