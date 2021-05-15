<section>

	<div class="container-do-test">

		<?= $menuTestDo; ?>

		<div class="content">

			<? if (isset($testData) && !isset($error) && !$testData == 0):// Проверим, чтобы запрашивали конекретный тест?>

				<div class="test-name"><?= $_SESSION['test_name']; ?></div>

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
										<img class="test-qpic" src="<?= '/pic/' . $item[0]['question_pic'] ?>"
										     alt="<?= substr($item[0]['question_pic'], 5); ?>">
									</div>
								<? endif; ?>
								<? unset($item[0]); ?>

								<? foreach ($item as $id_answer => $answer): ?>
									<? if (is_array($answer) and $id_answer !== 'correct_answer'): //выложим ответы               ?>

										<div class="a">
											<hr size=1,5px width=85% align="left">
											<input type="checkbox" name="question-<?= $id_quest ?>"
											       id="answer-<?= $id_answer ?>" value="<?= $id_answer ?>">
											<label for="answer-<?= $id_answer ?>"><?= $answer['answer_text'] ?></label>

											<? if ($answer['answer_pic']): ?>
												<div class="apic">
													<img src="<?= '/pic/' . $answer['answer_pic'] ?>" alt="">
												</div>
											<? endif ?>


										</div>
									<? endif; ?>
								<? endforeach; ?>
							</div>
						</div>
					<? endforeach; ?>
				</div>

				<a class="button" id="btnn" data-id="<?= $_SESSION['testId']; ?>">ЗАКОНЧИТЬ ТЕСТ</a>
			<? else: ?>

				<?= $error ?>

			<? endif; ?>
		</div>
		<?= $this::getJs() ?>

</section>
