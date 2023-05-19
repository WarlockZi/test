<div class="order">

	<div class="page-name">Заказ</div>

	<div class="row user">
		<div class="email"><?= $orders[0]->user->email ?></div>
		<div class="fio"><?= $orders[0]->user->fi() ?></div>
	</div>


	<? foreach ($orders as $order): ?>

	  <div class="row">
		  <div class="id"><?= $order->id ?></div>
		  <div class="id"><?= $order->product->name ?></div>
		  <div class="id"><?= $order->count ?></div>
<!--		  <div class="id">--><?//= $order->user->email ?><!--</div>-->

	  </div>

	<? endforeach; ?>

</div>


