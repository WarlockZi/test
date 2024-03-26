<? if ($product->activepromotions->count()): ?>

	<div class="promotions">
		<div class="promotion">Акция</div>
		 <? foreach ($product->activepromotions as $promotion): ?>
		  <div class="conditions">При покупке от
					<?= $promotion->count; ?>&nbsp;
					<?= $promotion->unit->name
					?? '<b style="color:red;">неустановленных единиц</b>'; ?>
			  <br>- цена <?= $promotion->new_price ?>
		  </div>
		 <p>Акция действует до : <br><?=$promotion->active_till ;?></p>
		 <? endforeach; ?>
	</div>


<? endif; ?>