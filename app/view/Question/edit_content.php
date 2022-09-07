<div class="test-edit__content">

	<? if (isset($test)): ?>

		<? if ($test['isTest']): ?>
			<? include ROOT . '/app/view/Test/isTest.php' ?>
		<? else: ?>
			<? include ROOT . '/app/view/Test/edit_children.php' ?>
		<? endif; ?>

		<? include ROOT . '/app/view/Test/test_edit_rules.php' ?>


	<? else: ?>
	  <h3></h3>
	<? endif; ?>

</div>
