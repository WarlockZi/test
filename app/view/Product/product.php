<?

use app\core\Auth;
use app\core\Icon;
use \app\view\Product\ProductFormView;
use \app\view\Product\ProductView;


if ($product): ?>


	<div class="product-card" data-id="<?= $product['1s_id']; ?>">

		 <?= $breadcrumbs ?>
		<h1><?= $product['name']; ?></h1>


		<div class="row">

			<div class="detail-image">
					 <?= ProductFormView::getCardImages('', $product->detailImages); ?>
			</div>

				<?= ProductView::getCardMainImage($product) ?>
				<? include __DIR__.'/card/toCart.php'?>
		</div>

		<!--		--><? //include __DIR__.'/card/packs.php'?>

		<div class="info-wrap">
			<div class="info-tag">Характеристики</div>
			<div class="properties">
					 <? foreach ($product->categoryProperties as $property): ?>
						 <?= ProductFormView::renderProperty($property); ?>
					 <? endforeach; ?>
			</div>
		</div>

		<div class="info-wrap">
			<div class="info-tag">Информация о товаре</div>
			<p class="detail-text">
					 <?= $product['txt']; ?>
			</p>
		</div>

		 <? //include __DIR__.'/card/olsoLike.php'?>
		 <? //include __DIR__.'/card/rating.php'?>

		 <? if (Auth::isAdmin()): ?>
		  <div class="edit">
			  <a href="/adminsc/product/edit/<?= $product->id ?>">Редакт</a>
		  </div>
		 <? endif; ?>

		 <?= Icon::star() ?>
		<!--		 --><? // include __DIR__ . '/card/reviews.php' ?>
		<!--		 --><? // include __DIR__ . '/card/alsoViewd.php.php' ?>

	</div>


<? else: ?>
	<div>Такого товара нет</div>
	<a href="/adminsc/category">Перейти в каталог</a>
<? endif; ?>
