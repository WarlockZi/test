<div class="lead-order">

	<div class="page-name">Заказ</div>

	<div class="column user"><b>Лид - </b>
		<div class="mame">Как зовут -<?= $orderitems['lead']->name?></div>
		<div class="phone">Телефон -<?= $orderitems['lead']->phone?></div>
		<div class="company">Компания -<?= $orderitems['lead']->company?></div>
	</div>

<br>
	<? foreach ($orderitems['oItems'] as $order): ?>

	  <div class="row">
		  <div class="num"><?= $order->id ?></div>
		  <div class="name-price">
			  <div class="name"><?= $order->product->name ?></div>
			  <div class="price"><?= $order->product->price ?></div>
			  <!--		  <div class="id">--><? //= $order->user->email ?><!--</div>-->
		  </div>
<!--		  --><?//$oI = $order->toArray();?>
		  <div class="count"><?= $order->count ?></div>
<!--		  <div class="count">--><?//= $order->total_count ?><!--</div>-->
	  </div>

	<? endforeach; ?>

</div>


