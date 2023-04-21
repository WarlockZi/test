<main class="cart">


	<? use app\core\Icon;

	if ($oItems->count()): ?>
		<? foreach ($oItems as $i => $oItem): ?>

		  <div class="row">
			  <div class="num"><?= ++$i; ?></div>

			  <div class="name" data-1sId="<?=$oItem->product['1s_id']?>"><?= $oItem->product->name; ?></div>
			  <img src="/pic/product/uploads/<?= $oItem->product->art . '.jpg' ?? ''; ?>"
			       alt="<?= $oItem->product->name; ?>">
			  <input type="number" class="count" min="0" value="<?= $oItem->count; ?>">
			  <div class="del"><?= Icon::trashWhite() ?></div>
		  </div>
		<? endforeach; ?>

	  <div class="popup-container">
		  <div class="button popup-show">Заказать</div>
	  </div>



	<? else: ?>
	  Корзина пуста

	<? endif; ?>

</main>

