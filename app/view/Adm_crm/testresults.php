<div class="adm-submenu">

	<div class="title">CRM</div>

	<? include ROOT . '/app/view/Adm_crm/components/adm-crm_menu.php'; ?>
</div>

<div class="adm-content">
	<h1>Результаты тестов</h1>

	<div class="test-reuslts__table">
		<? foreach ($res as $result): ?>
			<div class="item"> <?= $result['user']; ?></div>
			<a class="item" href='<?= '/test/result/' . $result['id']; ?>'
			   class="test-result"><?= $result['testname']; ?></a>
			<div class="item"> <?= $result['date']; ?></div>
		<? endforeach; ?>
	</div>
</div>