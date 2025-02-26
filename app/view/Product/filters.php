<div class="slider filters">
	<div class="wrap">
		 <? foreach ($filters as $k => $v): ?>
		  <div class="filter">
			  <input id="<?= $k; ?>" type="checkbox">
			  <label for="<?= $k; ?>"><?= $v; ?></label>
		  </div>
		 <? endforeach; ?>
	</div>
	<div class="slide">Фильтры</div>
</div>
