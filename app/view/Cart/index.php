<main class="cart">

<!--	--><?//= \app\core\Error::getErrorHtml();?>

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

		 <div class="button">Заказать</div>
	 
	<? else: ?>
	  Корзина пуста

	<? endif; ?>

</main>

<div class="container">
	<a class="button popup-button" href="#">Open Model!</a>
</div>

<div class="wrapper">
	<div class="popup-box">
		<h2>SIGN UP & GET 10% OFF</h2>
		<p>Subscribe to our newsletters now and stay up-to-date with new collections.</p>
		<a class="close-button popup-close" href="#">x</a><div class="form-group">
			<form method="post">
				<input type="email" name="useremail-id" required placeholder="Please Enter your email">
				<button type="submit" id="subscribe">SUBSCRIBE</button>
			</form>
		</div>
	</div>
</div>