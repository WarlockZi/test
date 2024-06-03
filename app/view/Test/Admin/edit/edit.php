<div class="test-edit-wrapper">

    <div class="test-head">
        <div class="accordion-open">Выбрать тест</div>
    </div>

    <div class="test-edit__cont">
       <?= $testView->getAccordion(); ?>

        <div class="extra-wrap">
           <?= $test ?? "Выберите тест для редактирования"; ?>
        </div>

    </div>
</div>



