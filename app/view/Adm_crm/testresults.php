<div class="adm-submenu">

	<div class="title">CRM</div>

	<? include ROOT . '/app/view/Adm_crm/components/adm-crm_menu.php'; ?>
</div>

<div class="adm-content">
	<h1>Результаты тестов</h1>

	<div class="test-reuslts__table">
		<? foreach ($res as $i): ?>
			<div class="item" data-row="<?=$i['id']?>"> <?= $i['user']; ?></div>
			<a class="item"  data-row="<?=$i['id']?>" href='<?= '/test/result/' . $i['id']; ?>'
			   class="test-result"><?= $i['testname']; ?></a>
			<div class="item <?= $i['errorCnt'] ? 'error' : 'suc' ?>" data-row="<?=$i['id']?>">
				вопр - <?= $i['questionCnt']; ?>
				ошибок - <?= $i['errorCnt']; ?>
			</div>
			<div class="item" data-row="<?=$i['id']?>"> <?= $i['date']; ?></div>
			<div class="item del" data-row="<?=$i['id']?>">удалить</div>
		<? endforeach; ?>
	</div>
</div>