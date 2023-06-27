<?

use app\core\Auth;
use app\core\Icon;

use app\view\Product\ProductFormView;
use \app\view\Product\ProductView;


if ($product): ?>


	<div class="product-card" data-id="<?= $product['1s_id']; ?>">

		 <?= $breadcrumbs ?>
		<h1><?= $product['name']; ?></h1>


		<div class="main-image-wrapper">

			<div class="detail-image">
					 <?= ProductFormView::getCardImages('', $product->detailImages); ?>
			</div>

				<?= ProductView::getCardMainImage($product) ?>
				<? include __DIR__.'/card/toCart.php'?>
		</div>

		<!--		--><? //include __DIR__.'/card/packs.php'?>

		 <? if (Auth::isAdmin()): ?>
		  <div class="product-card__edit">
			  <a href="/adminsc/product/edit/<?= $product->id ?>">Редакт</a>
		  </div>
		 <? endif; ?>

		<div class="info-wrap">
			<div class="info-tag">Характеристики</div>
			<div class="properties">
					 <? foreach ($product->values as $value): ?>
						 <? include __DIR__. '/property.php'; ?>
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


		 <?= Icon::star() ?>
		<!--		 --><? // include __DIR__ . '/card/reviews.php' ?>
		<!--		 --><? // include __DIR__ . '/card/alsoViewd.php.php' ?>

	</div>


<? else: ?>
	<div>Такого товара нет</div>
	<a href="/adminsc/category">Перейти в каталог</a>
<? endif; ?>
