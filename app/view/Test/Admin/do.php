<section class="test-do">
    <div class="test-head">
        <div class="accordion-open">Выбрать тест</div>
    </div>
    <div class="test">
       <?= $testView->getAccordion(); ?>
        <div class="content">
           <?= $testView->getPagination(); ?>
           <?= $testView->getContent(); ?>
        </div>
    </div>
</section>

