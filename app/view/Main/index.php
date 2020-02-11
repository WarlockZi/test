<main>

	<div class="info">
		<h1>Расходные материалы для медицины оптом</h1>
		<p>
			Обеспечим ваш медицинский центр, стоматологию или лабораторию перчатками,
			бахилами, масками и другими расходниками с бесплтной доставкой
			в оговоренные сроки. Поможем Вам найти оптимальное решение.
		</p>
		<h2>Широкий ассортимент</h2>
		<p>
			Оптимально подобранный перечень товаров поможет быстро
			сориентироварться в ассортименте. Мы не держим ничего лишнего.
		</p>
		<h2>Низкие цены</h2>
		<p>
			Покупая оптом, Вы снижаете затраты своего предприятия.
			Ведь лидеры рынка всегда уделяют большое внимание на затраты.
		</p>
		<h2>Доставим до дверей</h2>
		<p>
			Вам не нужно беспокоится о доставке. Мы огранизуем и доставим
			ваш товар бесплатно почти в любую точку России.
			Даже если ваше предприятие не имеет собственного транспорта,
			составив заявку на доставку "до дверей", товар вы получите в
			оговоренный срок.
		</p>
		<h2>Вся продукция сертифицирована</h2>
		<p>
			На всю приобретенную у нас продукцию Вы получаете российские сертификаты
			на соответствие ГОСТам.
		</p>
	</div>
	<div class="sale-action-wrap column ">
		<span>акция !!!</span>
		<div class="white-space">

			<div id="slides">
				<? $i = 0; ?>
				<? foreach ($sale as $product) : ?>
				<? $i++; ?>
				<div class="slide <?=$i==1?'showing':''?>" >
             <a href="/<?= $product['alias']; ?>">
				<div class="image-height column pic">
					<img src="/pic<?= $product['dpic']; ?>" alt="<?= $product['name']; ?>">
					<div><?= $product['name']; ?> </div>
				</div>
				</a>
			</div>
			<? endforeach; ?>
		</div>

	</div>
	</div>
</main>
<script src="/public/build/mainIndex.js"></script>
