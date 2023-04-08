<div class="filters">
	<? foreach ($filters as $k => $v): ?>
	<div class="filter">
	  <input id="<?= $k; ?>" type="checkbox">
	  <label for="<?= $k; ?>"><?= $v; ?></label>
	</div>
	<? endforeach; ?>
</div>
