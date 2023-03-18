<!--TABS-->
<div class="tabs_wrap">
	<div data-tab-id="1"
	     class="tab active"

	>Основное
	</div>
	<? $n = 2; ?>
	<? foreach ($this->tabs as $k => $tab): ?>
	  <div data-tab-id="<?= $n; ?>"
	       class="tab"
	  >
	    <?= $tab->tabTitle; ?>
	  </div>
		<? $n++; ?>
	<? endforeach; ?>
</div>
