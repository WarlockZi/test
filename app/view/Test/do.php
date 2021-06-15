<section>

	<div class="container-do-test">

		<?= $menuTestDo; ?>

		<div class="content">

			<? if (isset($testData) && !isset($error) && !$testData == 0):// Проверим, чтобы запрашивали конекретный тест?>

				<div class="test-name" data-test-id =<?=$test['id']?> ><?= $test['test_name']; ?></div>

				<?=
				$pagination;
				$i = 1;
				?>

				<div class="test-data">

					<? foreach ($testData as $id_quest => $item): ?>
						<div class="question" data-id="<? echo $id_quest; ?>" id="question-<?= $id_quest; ?>">


							<div class="q">
								<div class="num"><?= $i++ ?></div>
								<div class="q-text"><?= $item[0]['question_text'] ?></div>

								<? if ($item[0]['question_pic']): ?>
									<div class="qpic">
										<img class="test-qpic"
										     src="<?= $item[0]['question_pic'] ? '/pic/' . $item[0]['question_pic'] : '' ?>">
									</div>
								<? endif; ?>
								<? unset($item[0]); ?>

								<? foreach ($item as $id_answer => $answer): ?>
									<? if (is_array($answer) and $id_answer !== 'correct_answer'): ?>
							</div>

										<div class="a">
											<input type="checkbox" id="answer-<?= $id_answer ?>">
											<label for="answer-<?= $id_answer ?>"></label>
											<div><?= $answer['answer_text'] ?></div>

											<? if ($answer['answer_pic']): ?>
												<div class="apic">
													<img src="<?= '/pic/' . $answer['answer_pic'] ?>" alt="">
												</div>
											<? endif ?>


									<? endif; ?>
								<? endforeach; ?>
							</div>
						</div>
					<? endforeach; ?>
				</div>

				<a class="button" id="btnn" data-id="<?= $test['id']; ?>">ЗАКОНЧИТЬ ТЕСТ</a>
			<? else: ?>

				<?= $error ?>

			<? endif; ?>
		</div>

</section>
