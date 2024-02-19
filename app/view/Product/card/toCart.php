<?

use app\core\Icon;

?>

<div class="to-cart">

	<div class="short-link" title = 'Скопировать короткую ссылку'
	     data-shortLink = <?='https://vitexopt.ru/product/'.$product->short_link?>><?=Icon::link();?>
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

		 $mainUnit = $product->baseUnit->units
		   ->where('pivot.product_id', $product['1s_id'])
		   ->where('pivot.main', 1)
		   ->first();
		 if ($mainUnit) {
			 $unitName = $mainUnit->name;
			 $multiplier = $mainUnit->pivot->multiplier;
		 } else {
			 $unitName = $product->baseUnit->name;
			 $multiplier = 1;
		 }
		 ?>
			<span class="digit" contenteditable="true">1</span><span><?=$unitName?></span>
			<button tabindex="0" class="plus">
					 <?= Icon::plus1() ?>

			</button>
		</div>
	</div>
</div>
