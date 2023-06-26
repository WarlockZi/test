<? use app\view\UserView;?>
<div class="order">

	<div class="page-name">Заказ</div>

	<div class="row user">
		<div class="client">
			Клиент -
		</div>
		<div class="email"><?= $orders[0]->user->email ?></div>
		<div class="fio"><?= $orders[0]->user->fi() ?></div>
	</div>

	<div class="row manager">
		<div class="manager">
			Менеджер -
		</div>
		 <?= UserView::getManagerSecector(); ?>
	</div>

	<? foreach ($orders as $order): ?>
		<? if ($order->product): ?>

		  <div class="row">
			  <div class="num"><?= $order->id ?></div>
			  <div class="name-price">
				  <div class="name"><?= $order->product->name ?></div>
				  <div class="price"></div>
				  <!--		  <div class="id">--><? //= $order->user->email ?><!--</div>-->
			  </div>
			  <div class="count"><?= $order->total_count ?></div>
		  </div>
		<? else: ?>
		  <div class="not-found">Товар не найден</div>
		<? endif; ?>
	<? endforeach; ?>

</div>


