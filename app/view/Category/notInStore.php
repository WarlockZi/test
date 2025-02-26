<? foreach ($category->productsNotInStore as $product): ?>
  <?= CategoryView::getProductCard($product, $icon) ?>
<? endforeach; ?>
