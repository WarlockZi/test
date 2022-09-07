<div class="test-data">

	<? foreach ($testData as $id_quest => $item): ?>
	  <div class="question" data-id="<?= $item['id']; ?>">

		  <div class="q">
			  <div class="num"><?= $id_quest + 1; ?></div>
			  <div class="q-text"><?= $item['qustion'] ?></div>

		  </div>

			 <? if ($item['picq']): ?>
			 <div class="qpic">
				 <img class="test-qpic"
				 src="<?= \app\Repository\ImageRepository::getImg('/pic/' . $item['picq']); ?>">
			 </div>
			 <? endif; ?>

			 <? if (isset($item["Answer"])) : ?>
				 <? foreach ($item["Answer"] as $index => $answer): ?>
				 <div class="a" data-id=<?= $answer['id']; ?>>
					 <input type="checkbox" id="answer-<?= $answer['id'] ?>">
					 <label for="answer-<?= $answer['id'] ?>"><?= $answer['answer'] ?></label>

							 <? if ($answer['pica']): ?>
						<div class="apic">
							<img src="<?= \app\Repository\ImageRepository::getImg('/pic/' . $answer['pica']) ?>" alt="">
						</div>
							 <? endif; ?>
				 </div>
				 <? endforeach; ?>
			 <? endif; ?>

	  </div>
	<? endforeach; ?>


</div>
<? include ROOT . '/app/view/components/test/test_edit_prev_next_buttons.php' ?>

<a class="test-do__finish-btn" data-id="<?= $test['id']; ?>">ЗАКОНЧИТЬ ТЕСТ</a>
</div>

