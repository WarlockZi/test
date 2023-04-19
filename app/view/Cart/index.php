<main class="cart">

	<? if ($oItems->count()): ?>
		<? foreach ($oItems as $i => $oItem): ?>

		  <div class="row">
			  <div class="num"><?= ++$i; ?></div>
			  <div class="name"><?= $oItem->product->name; ?></div>
			  <img src="<?= $oItem->product->name; ?>" alt="<?= $oItem->product->name; ?>">
			  <input type="number" class="count" min="0" value="<?= $oItem->count; ?>"/>
		  </div>
		<? endforeach; ?>
	<? else: ?>
	  Корзина пуста

	<? endif; ?>

</main>