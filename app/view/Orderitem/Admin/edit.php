<div class="order">

	<div class="page-name">Заказ</div>

	<div class="column user"><b>Лид - </b>
		<div class="mame">Как зовут -<?= $orderitems['lead']->name?></div>
		<div class="phone">Телефон -<?= $orderitems['lead']->phone?></div>
		<div class="company">Компания -<?= $orderitems['lead']->company?></div>
	</div>


	<? foreach ($orderitems['oItems'] as $order): ?>

	  <div class="row">
		  <div class="num"><?= $order->id ?></div>
		  <div class="name-price">
			  <div class="name"><?= $order->product->name ?></div>
			  <div class="price"></div>
			  <!--		  <div class="id">--><? //= $order->user->email ?><!--</div>-->
		  </div>
		  <div class="count"><?= $order->total_count ?></div>
	  </div>

	<? endforeach; ?>

</div>


