<?

use app\core\Icon;

?>

<div class="to-cart">

	<div class="short-link" title='Скопировать короткую ссылку'
	     data-shortLink= <?= $product->getShortLink(); ?>><?= Icon::link(); ?>
	</div>
	<div class="art">Арт. <?= $product->art ?></div>

	<? include __DIR__ . '/price.php' ?>
	<? include __DIR__ . '/promotion.php' ?>

	<? include __DIR__ . '/count.php' ?>
	<div class="button blue">Добавить в корзину</div>

	<div class="adjust none">
		<a href="/cart" class="button green">
			<span class='bigger'>В корзину</span>
		</a>

		<div class="plus-minus">
			<button tabindex="0" class="minus">
					 <?= Icon::minus() ?>
			</button>
				<?
				$produt = $product->toArray();
				$am = $product->baseUnit->units->toArray();
				if (isset($product->baseUnit->units->mainUnit)) {
					$unitName = $product->baseUnit->units->mainUnit->name;
					$multiplier = $product->baseUnit->units->mainUnit->pivot->multiplier;
				} else {
					$unitName = $product->baseUnit->name;
					$multiplier = 1;
				}

				?>
			<span class="digit" contenteditable="true">1</span><span><?= $unitName ?></span>
			<button tabindex="0" class="plus">
					 <?= Icon::plus1() ?>

			</button>
		</div>
	</div>
</div>
