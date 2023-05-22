<div class="order">

	<div class="page-name">Заказ</div>

	<div class="row user"><b>Клиент - </b>
		<div class="email"><?= $orders[0]->user->email ?></div>
		<div class="fio"><?= $orders[0]->user->fi() ?></div>
	</div>


	<? foreach ($orders as $order): ?>

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


