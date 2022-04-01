
<div class="adm-content">

	<div class="page-name">Результаты тестов</div>

	<div class="test-results__table">
		<? foreach ($res as $i): ?>
			<div class="item" data-row="<?= $i['id'] ?>"> <?= $i['user']; ?></div>
			<a class="item" data-row="<?= $i['id'] ?>" href='<?= '/test/result/' . $i['id']; ?>'
			   class="test-result"><?= $i['testname']; ?></a>
			<div class="item <?= $i['errorCnt'] ? 'error' : 'suc' ?>" data-row="<?= $i['id'] ?>">
				вопр - <?= $i['questionCnt']; ?>
				ошибок - <?= $i['errorCnt']; ?>
			</div>
			<div class="item" data-row="<?= $i['id'] ?>"> <?= $i['date']; ?></div>

			<div class="item del-btn <?= (in_array('test-results_del', $this->user['rights'])) ? 'del' : ''; ?>" data-row="<?= $i['id'] ?>">
				<? include TRASH;?>
			</div>
		<? endforeach; ?>
	</div>
</div>