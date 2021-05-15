<section>

	<div class="container-do-test">

		<div class='test-menu-wrap'>
		<?=$testsMenu?>
		</div>

		<div class="content">
			<? if (!isset($error)): ?>

			<div class="test-name"><?= $testName; ?></div>

			<?= $pagination ?>

			<? $i = 1 ?>
			<div class="test-data">


				<? foreach ($testData as $id_quest => $item): ?>
					<div class="question" data-id="<? echo $item['id']; ?>">


						<div class="q">
							<div class="num"><?= $i++ ?></div>
							<div class="q-text"><?= $item['question'] ?></div>

							<? if (isset($item['picq']) && $item['picq']): ?>
								<div class="qpic">
									<img class="test-qpic" src="<?= '/pic/' . $item['picq'] ?>"
									     alt="<?= substr($item['picq'], 5); ?>">
								</div>
							<? endif; ?>


						</div>

						<div class="freetest-text-editable" data-textarea="<?= $item['id'] ?>" contenteditable="true"></div>
					</div>

				<? endforeach; ?>
			</div>

			<a class="button" id="finish-freetest" data-id="<?= $testId; ?>">ЗАКОНЧИТЬ ТЕСТ</a>

		</div>

		<? endif; ?>

</section>