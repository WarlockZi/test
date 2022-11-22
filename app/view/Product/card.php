<main class="card">

<!--	--><?//= $breadcrumbs ?>

	<? if ($product): ?>
	<?include ROOT.'/app/view/Catalog/product.php';?>

<!--	  <div class="card">-->
<!--		  <div class="left_column">-->
<!---->
<!--			  <img src="/pic/product/--><?//= $card['main_image']['hash'] . '.jpeg' ?><!--" alt="">-->
<!--			  <br>-->
<!--			  <div>Товар - <span>--><?//= $card['name'] ?><!--</span></div>-->
<!--			  <br>-->
<!--			  <div>Артикул - <span>--><?//= $card['art'] ?><!--</span></div>-->
<!--		  </div>-->
<!---->
<!--		  <div class="right_column">-->
<!--			  <br>-->
<!--			  <div>Описание - <span>--><?//= $card['dtxt'] ?><!--</span></div>-->
<!--		  </div>-->
<!---->
<!--	  </div>-->

	<? else: ?>

	  <div>Такого товара нет</div>

	<? endif; ?>
</main>
