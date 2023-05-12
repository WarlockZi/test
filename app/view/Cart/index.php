<div class="cart">
	<? use app\core\Icon;

	if ($oItems->count()): ?>
	<div id="counter">
		<p>Отлично! </p>
		<p>Чтобы мы смогли обработать ваш заказ - оставьте свои данные!</p>
		<p>Иначе корзина сгорит через</p>

		<div id="timer">
			<div class="items">
				<div class="item days">00</div>
				<div class="item hours">00</div>
				<div class="item minutes">00</div>
				<div class="item seconds">00</div>
			</div>
		</div>

	</div>


		<? foreach ($oItems as $i => $oItem): ?>

		  <div class="row" data-product-id="<?= $oItem->product_id?>">
			  <div class="num"><?= ++$i; ?></div>

			  <div class="name"><?= $oItem->product->name; ?></div>
			  <img src="/pic/product/uploads/<?= $oItem->product->art . '.jpg' ?? ''; ?>"
			       alt="<?= $oItem->product->name; ?>">
			  <input type="number" class="count" min="0" value="<?= $oItem->count; ?>">
			  <div class="unit"><?=$oItem->product->baseUnit->name?></div>
			  <div class="del"><?= Icon::trashWhite() ?></div>
		  </div>
		<? endforeach; ?>

	  <div class="popup-container">
		  <div id="cartLead" class="button popup-show">Оставить свои данные</div>
	  </div>

		<div class="popup-container">
			<div id="cartLogin" class="button popup-show">Войти под своей учеткой</div>
		</div>

	<? else: ?>
	  Корзина пуста

	<? endif; ?>

</div>

