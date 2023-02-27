<div class="testresult">

	<div class="head">
		<a href="/adminsc/testresult"
		   class='to-list'>
			К списку результатов
		</a>
		<p>Студент - <?= $res['user'] ?></p>
		<p>Дата - <?= $res['date'] ?></p>
		<p>Название теста - <?= $res['testname'] ?></p>
	</div>

	<?= $testHtml; ?>

</div>


