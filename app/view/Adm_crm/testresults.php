<div class="adm-submenu">


	<div class="title">CRM</div>

	<? include ROOT . '/app/view/Adm_crm/components/adm-crm_menu.php'; ?>
</div>

<div class="adm-content">
	<h1>Результаты тестов</h1>

	<? foreach ($files as $href => $file): ?>
		<a href = '<?='/test/results/'.$file['filename'];?>' class="test-result"><?= $file['filename']; ?></a>
	<br>
	<? endforeach; ?>


</div>