<div class="cart">
	<? use app\core\Icon; ?>

	<div class="<?= $oItems->count() ? '' : 'none'; ?> content">


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

		  <div class="row" data-product-id="<?= $oItem->product_id ?>">
			  <div class="num"><?= ++$i; ?></div>

			  <img src="/pic/product/uploads/<?= $oItem->product->art . '.jpg' ?? ''; ?>"
			       alt="<?= $oItem->product->name; ?>">
			  <div class="name-price">
				  <div class="name"><?= $oItem->product->name; ?></div>
				  <div class="price" data-price=<?=$oItem->product->getRelation('price')->price;?>><?= $oItem->product->priceWithCurrencyUnit() ?></div>
			  </div>
			  <input type="number" class="count" min="0" max="999999" value="<?= $oItem->count; ?>">

			  <div class="sum"></div>
			  <div class="del"><?= Icon::trashWhite() ?></div>

		  </div>
		 <? endforeach; ?>

		<div class="total">Всего -&nbsp;&nbsp;<span></span>&nbsp;&nbsp;руб.</div>

		<div class="buttons">
			<div class="button" id="cartLead"  >Оставить свои данные</div>
			<div class="button" id="cartLogin" >Войти под своей учеткой</div>
		</div>
	</div>

	<div class="empty-cart <?= $oItems->count() ? 'none' : ''; ?>">
		Корзина пуста
	</div>


</div>

