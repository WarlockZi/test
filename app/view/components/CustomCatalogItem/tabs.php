<!--TABS-->
<div data-id="1"
     class="tab active"
     data-tooltip="Основное">Основное
</div>
<? $n = 2; ?>
<? foreach ($this->tabs as $k => $tab): ?>
	<div data-id="<?= $n; ?>"
	     class="tab"
	     data-tooltip="<?= $k; ?>"><?= $k; ?></div>
	<? $n++; ?>
<? endforeach; ?>