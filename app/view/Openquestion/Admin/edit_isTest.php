<? use \app\Repository\OpenquestionRepository;
use \app\Repository\AnswerRepository; ?>
<div class="test-edit__title">
    <p class="test-name">Редактировать открытый тест - <?= $test->name; ?></p>
</div>

<div class="questions" data-test-id="<?= $test->id; ?>">

    <div class="empty">
        <?= \app\Repository\OpenquestionRepository::empty($test); ?>
        <!--		 --><? //= AnswerRepository::empty(); ?>
    </div>

    <? if ($test->questions): ?>
        <? foreach ($test->questions as $question): ?>
            <?= OpenquestionRepository::getQuestion($question, $parentSelector); ?>
        <? endforeach; ?>
    <? else: ?>
        <h3>Вопросов нет</h3>
    <? endif; ?>

    <div class="question__create-button">
        + Добавить вопрос
    </div>
</div>

