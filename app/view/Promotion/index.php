<div class="promotions-index">
	<div class="page-title">
		Акции

	</div>

	<? foreach ($promotions as $promotion): ?>
		<? if ($promotion && $promotion->product): ?>
		  <div class="promotion row">

					<?
					$unit = $promotion->product->baseUnit->name
					?>


			  <div class="old-price">
				  цена без акции - <?= $promotion->product->getRelation('price')->price ?>
			  </div>
			  <div class="new-price">
				  <div class="price">
					  цена по акции - <?= $promotion->new_price; ?>

				  </div>
				  <div class="count">
					  oт <?= $promotion->count; ?> <?= $unit; ?>
				  </div>
			  </div>
			  <a href="/product/<?= $promotion->product->slug ?>" class="main-image">
				  <img src="<?= $promotion->product->mainImagePath; ?>" alt="">
			  </a>

			  <div class="active-till">
				  действует до - <?= $promotion->active_till ?>
			  </div>
		  </div>
		<? endif; ?>
	<? endforeach; ?>
</div>
