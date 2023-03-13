<div class="test">

  <? if ($test): ?>

<!--    --><?//= $test->getTitle(); ?>
    <?= $test->getPagination(); ?>

    <? include ROOT . '/app/view/Test/Admin/do_test-data.php'; ?>

  <? else: ?>
		<?=$test->getNoTestTitle()?>
  <? endif; ?>

</div>



