<div class="test-edit__content">

    <div class="test-edit__title">
        <? if (isset($test['isTest']) && $test['isTest']): ?>

            <p class="test-name"><?= $test['name'] ?></p>


            <div class="questions" data-test-id="<?= $test['id'] ?>">

                <? $parent_selector = \app\view\OpenTest\OpentestView1::getParentSelector(0, $test['id']); ?>

                <? foreach ($test['questions'] as $id => $block): ?>
                    <? include ROOT . '/app/view/OpenTest/edit_BlockQuestion.php' ?>
                <? endforeach; ?>

                <div class="question__create-button"
                >
                    + Добавить вопрос
                </div>
            </div>

        <? else: ?>
            <p class="test-name"
               value="<?= $_REQUEST['id'] ?? $test['id'] ?>"><?= $_REQUEST['name'] ?? $test['name'] ?>
            </p>
            <? include ROOT . '/app/view/Opentest/edit_children.php' ?>
        <? endif; ?>

    </div>

    <? include ROOT . "/app/view/Opentest/edit_rules.php"; ?>


</div>
