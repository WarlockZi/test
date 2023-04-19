<main class="cart">

	<? use app\core\Icon;

	 if ($oItems->count()): ?>
		<? foreach ($oItems as $i => $oItem): ?>

		  <div class="row">
			  <div class="num"><?= ++$i; ?></div>

			  <div class="name"><?= $oItem->product->name; ?></div>
			  <img src="/pic/product/uploads/<?= $oItem->product->art . '.jpg' ?? ''; ?>"
			       alt="<?= $oItem->product->name; ?>">
			  <input type="number" class="count" min="0" value="<?= $oItem->count; ?>">
			  <div class="del"><?= Icon::trashWhite()?></div>
		  </div>
		<? endforeach; ?>
	<? else: ?>
	  Корзина пуста

	<? endif; ?>

</main>