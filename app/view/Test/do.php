<div class="adm-content">

	<section class="test-do">

		 <? include ROOT . '/app/view/Test/test_head.php'; ?>

		<div class="content">
				<? include ROOT . '/app/view/Test/test_do_accordion.php'; ?>

				<? if ($test): ?>
					<? include ROOT . '/app/view/Test/do_content.php'; ?>
				<? else: ?>
			  <h2></h2>
				<? endif; ?>

	</section>
</div>
