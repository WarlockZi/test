<!--TABS-->
<div class="tabs_wrap">
	<div data-tab-id="1"
	     class="tab active"
	     data-tooltip="Основное">Основное
	</div>
	<? $n = 2; ?>
	<? foreach ($this->tabs as $k => $tab): ?>
	  <div data-tab-id="<?= $n; ?>"
	       class="tab"
	       data-tooltip="<?= $tab['title']; ?>"><?= $tab['title']; ?></div>
		<? $n++; ?>
	<? endforeach; ?>
</div>
