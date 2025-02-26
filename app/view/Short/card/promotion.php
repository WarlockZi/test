<? if ($product->promotions->count()): ?>
	<div class="promotions">
		<div class="promotion">Акция</div>
		 <? foreach ($product->promotions as $promotion): ?>
		  <div class="conditions">При покупке от
					<?= $promotion->count; ?>&nbsp;
					<?= $promotion->unit->name
					?? '<b style="color:red;">неустановленных единиц</b>'; ?>
			  - цена <?= $promotion->new_price ?>
		  </div>
		 <p>Акция действует до : <?=$promotion->active_till ;?></p>
		 <? endforeach; ?>
	</div>

<? endif; ?>