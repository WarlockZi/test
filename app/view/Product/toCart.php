<?

use app\core\Icon;

?>

<div class="to-cart">

	<? include __DIR__ . '/Main/toCart.php' ?>
	<div class="button blue">Добавить в корзину</div>

	<div class="adjust none">
		<a href="/cart" class="button green">
			<span class='bigger'>В корзину</span>
		</a>

		<div class="plus-minus">
			<button tabindex="0" class="minus">
					 <?= Icon::minus() ?>
			</button>
			<span class="digit" contenteditable="true">1</span>
			<button tabindex="0" class="plus">
					 <?= Icon::plus1() ?>

			</button>
		</div>
	</div>
</div>
