<?php if ($product->activepromotions->count()): ?>

	<div class="promotions">
		<div class="promotion">Акция</div>
        <?php foreach ($product->activepromotions as $promotion): ?>
		  <div class="conditions">При покупке от
					<?= $promotion->count?? '<b style="color:red;">неустановленного количества</b>';; ?>&nbsp;
					<?= $promotion->unit->name
					?? '<b style="color:red;">неустановленных единиц</b>'; ?>
			  <br>- цена <?= $promotion->new_price?? '<b style="color:red;">неустановленная цена</b>'; ?>
		  </div>
		 <p>Акция действует до : <br><?=$promotion->active_till ;?></p>
        <?php endforeach; ?>
	</div>


<?php endif; ?>