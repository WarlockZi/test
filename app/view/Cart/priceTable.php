<div class="price-table">
	<?

	$id = $oItem->product['1s_id'];
	$filtered = $oItem->product->baseUnit->units
		->filter(function ($v, $k) use ($id) {
			return $v->pivot->product_id === $id;
		})->all();

	foreach ($filtered as $unit): ?>
	  <div class="row">

			 <?
			 $price = $oItem->product->getRelation('price')->price;
			 $multiplier = $unit->pivot->multiplier;
			 $price = $price * $multiplier;

			 echo number_format($price, 2, '.', ' ');
			 ?>

		  /
			 <?= $unit->name; ?>
	  </div>
	<? endforeach; ?>
</div>