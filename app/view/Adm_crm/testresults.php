<div class="adm-submenu">


	<div class="title">CRM</div>

	<? include ROOT . '/app/view/Adm_crm/components/adm-crm_menu.php'; ?>
</div>

<div class="adm-content">

	<? foreach ($files as $href => $file): ?>
		<a href = '<?='/test/results/'.$file['name'];?>' class="test-result"><?= $file['name']; ?></a>
	<br>
	<? endforeach; ?>


</div>