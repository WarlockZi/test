<?

use \app\Repository\ImageRepository;
use \app\view\Product\ProductView;

?>

<? if ($product): ?>

	<main class="vitex-content">

		<div class="product-card">

				<?= $breadcrumbs ?>
			<h1><?= $product['name']; ?></h1>


			<div class="row">

				<div class="main-image">
							<?= ImageRepository::getProductMainImage($product); ?>
				</div>

				<div class="properties">

					<div class="row">
						<div class="property">
						<span>
						Артикул
						</span>
						</div>
						<div class="value"><?= $product->art; ?></div>
					</div>

					<div class="row">
						<div class="property">
						<span>
						Страна
						</span>
						</div>
						<div class="value"><?= $product->manufacturer->country->name ?? 'Неизвестна'; ?></div>
					</div>

					<div class="row">
						<div class="property">
						<span>
						Производитель
						</span>
						</div>
						<div class="value"><?= $product->manufacturer->name ?? 'Неизвестен'; ?></div>
					</div>

				</div>
			</div>

			<div class="row">
					 <?= ProductView::getCardImages('Датальные картинки товара',
						 $product->detailImages); ?>
			</div>

			<div class="row">
					 <?= ProductView::getCardImages('Вид внутритранспортной упоковки',
						 $product->smallpackImages); ?>
			</div>

			<div class="row">
					 <?= ProductView::getCardImages('Вид транспортной упоковки',
						 $product->bigpackImages); ?>
			</div>

			<div class="info-wrap">
				<h3 class="info-tag">Информация о товаре</h3>
				<p class="detail-text">
							<?= $product['dtxt'] ?>
				</p>
			</div>


			<div class="may-also-like-wrap">
				<h3 class="info-tag">Вам также может понравится</h3>
				<div class="may-also-like-title">

					<div class="thumb-big"></div>
					<div class="thumb-big"></div>
					<div class="thumb-big"></div>
					<div class="thumb-big"></div>

				</div>
			</div>

			<div class="cust-questions-wrap">
				<h3 class="info-tag">Вопросы покупателей</h3>
				<div class="info">
					<p>Есть вопросы по данному продукту? Задайте их здесь. </p>
					<p>Вы получите уведомление на указанный email, когда ответ будет готов. </p>
				</div>
			</div>

			<div class="cust-questions-wrap">
				<h3 class="info-tag">Оставьте свой отзыв</h3>
				<ol>
					<li>
						<span class="info">Вам понравился продукт</span></li>
						<input type="text">
					<li>
						<span class="info">Напишите свой отзыв</span></li>
						<input type="text">
					<li>
						<span class="info">Расскажите нам немного о себе</span>
						<input type="text">
					</li>


				</ol>

			</div>

			<div class="note">
				Внимание: предоставляя отзыв вы подтверждаете и гарантируете, что вам исполнилось 18 лет. Ваш отзыв
				будет рассмотрен в течение 5 дней.
			</div>


			<h3 class="info-tag">Рейтинг</h3>
			<div class="star-rating">
				<div class="star-rating__wrap">
					<input id="star-rating-5" type="radio" value="5">
					<label class="star" for="star-rating-5"></label>
					<input id="star-rating-4" type="radio" value="4">
					<label class="star" for="star-rating-4"></label>
					<input id="star-rating-3" type="radio" value="3">
					<label class="star" for="star-rating-3"></label>
					<input id="star-rating-2" type="radio" value="2">
					<label class="star" for="star-rating-2"></label>
					<input id="star-rating-1" type="radio" value="1">
					<label class="star" for="star-rating-1"></label>
				</div>
			</div>

			<h3 class="info-tag">Отзывы</h3>

			<span class="share">
            <span class="share-title">Поделиться</span>
            <svg viewBox="-200 -150 2100 2100" class="f" fill="#fff" preserveAspectRatio="xMidYMid meet" height="100"
                 width="1000" role="img" aria-labelledby="title"><title>Facebook</title><path
			            d="M1343 12v264h-157q-86 0-116 36t-30 108v189h293l-39 296h-254v759h-306v-759h-255v-296h255v-218q0-186 104-288.5t277-102.5q147 0 228 12z"
			            fill="#fff"></path></svg>
          </span>

			<div class="also-viewed">
			</div>
		</div>

		</div>

	</main>

<? else: ?>
	<div>Такого товара нет</div>
	<a href="/adminsc/category">Перейти в каталог</a>
<? endif; ?>
