<? include ROOT . '/app/view/Test/Admin/test_edit_prev_next_buttons.php' ?>

<div class="test-data test-do">

    <? foreach ($test->questions as $id_quest => $question): ?>
	  <div class="question" data-id="<?= $question->id; ?>">

		  <div class="q">
			  <div class="num"><?= $id_quest + 1; ?></div>
			  <div class="q-text"><?= $question->qustion ?></div>

		  </div>

			 <?= \app\view\Question\QuestionView::getImg($question) ?>

			 <? if (isset($question->answers)) : ?>
				 <? foreach ($question->answers as $index => $answer): ?>
				 <div class="a" data-id=<?= $answer->id; ?>>
					 <input type="checkbox" id="answer-<?= $answer->id ?>">
					 <label for="answer-<?= $answer->id ?>"><?= $answer->answer ?></label>

							 <?= \app\Repository\AnswerRepository::getImg($answer) ?>


				 </div>
				 <? endforeach; ?>
			 <? endif; ?>

	  </div>
	<? endforeach; ?>
</div>
