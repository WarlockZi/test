<? use app\Repository\ImageRepository; ?>

<div class="test-data">

	<? foreach ($test->questions as $id_quest => $question): ?>
	  <div class="question" data-id="<?= $question->id; ?>">

		  <div class="q">
			  <div class="num"><?= $id_quest + 1; ?></div>
			  <div class="q-text"><?= $question->qustion ?></div>

		  </div>

			 <? if ($question->picq): ?>
			 <div class="qpic">
				 <img class="test-qpic"
				      src="<?= ImageRepository::getImg('/pic/' . $question->picq); ?>">
			 </div>
			 <? endif; ?>

			 <? if (isset($question->answers)) : ?>
				 <? foreach ($question->answers as $index => $answer): ?>
				 <div class="a" data-id=<?= $answer->id; ?>>
					 <input type="checkbox" id="answer-<?= $answer->id ?>">
					 <label for="answer-<?= $answer->id ?>"><?= $answer->answer ?></label>

							 <? if ($answer->pica): ?>
						<div class="apic">
							<img src="<?= ImageRepository::getImg('/pic/' . $answer->pica) ?>" alt="">
						</div>
							 <? endif; ?>
				 </div>
				 <? endforeach; ?>
			 <? endif; ?>

	  </div>
	<? endforeach; ?>


</div>
<? include ROOT . '/app/view/Test/test_edit_prev_next_buttons.php' ?>

<a class="test-do__finish-btn" data-id="<?= $test->id; ?>">ЗАКОНЧИТЬ ТЕСТ</a>
</div>

