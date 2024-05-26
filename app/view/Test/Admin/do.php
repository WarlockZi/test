<?php $testService = new \app\Services\Test\TestDoService($id); ?>
<section class="test-do">
   <? include ROOT . '/app/view/Test/test_head.php'; ?>
    <div class="content">
       <?= $testService->getAccordion(); ?>
        <div class="test">
           <?= $testService->getPagination(); ?>
           <?= $testService->getContent(); ?>
        </div>
</section>

