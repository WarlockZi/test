<!--TABS-->
<div class="tabs_wrap">
	<div data-tab-id="1"
	     class="tab active"

	>Основное
	</div>
    <?php $n = 2; ?>
    <?php foreach ($tabs as $k => $tab): ?>
	  <div data-tab-id="<?= $n; ?>"
	       class="tab"
	  >
	    <?= $tab->tabTitle; ?>
	  </div>
        <?php $n++; ?>
    <?php endforeach; ?>
</div>
