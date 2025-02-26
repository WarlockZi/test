<section class="test-do">
    <div class="test-head">
        <div class="accordion-open">Выбрать тест</div>
    </div>
    <div class="test">
       <?= $testView->getAccordion(); ?>
        <div class="content">
           <?= $testView->getPagination($test); ?>
           <?= $testView->getContent($test); ?>
        </div>
    </div>
</section>

