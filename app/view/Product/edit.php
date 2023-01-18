<div class="adm-content">

  <? if ($product): ?>

    <?= $breadcrumbs; ?>
    <?= $product ?>

  <? else: ?>
		<div>Такого товара нет</div>
		<br>
		<a href="/adminsc/category">Перейти в каталог</a>
  <? endif; ?>

</div>



