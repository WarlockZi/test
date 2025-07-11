<?

use app\repository\AnswerRepository;
use app\repository\QuestionRepository;
use app\view\Question\QuestionView;


?>
<div class="test-edit__title">
    <p class="test-name">Редактировать тест - <?= $test->name; ?></p>
</div>

<div class="questions" data-test-id="<?= $test->id; ?>">

    <div class="empty">
        <?= QuestionRepository::empty($test, $parentSelector); ?>
        <?= AnswerRepository::empty(); ?>
    </div>

    <? if ($test->questions): ?>

        <?= QuestionView::getEditQuestions($test, $parentSelector) ?>

    <? else: ?>

        <h3>Вопросов нет</h3>

    <? endif; ?>

    <div class="question__create-button">
        + Добавить вопрос
    </div>
</div>

