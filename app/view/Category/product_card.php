<div class="column">
    <?= $case->showProductPromotionLable($product) ?>
    <a data-instore="<?= $product->instore ?? 0; ?>"

       href="/product/<?= $product->slug; ?>" class="product">


        <h3 class="name"><?= $product->print_name; ?></h3>
        <img src="<?=$product->mainImagePath?>" alt="<?=$product->name?>" loading="lazy">
        <span class="footer">

					 <p>Цена: <?= $product->baseUnitPrice;?></p>
					 <p>Статус:  <?= $case->showProductStatus($product) ?></p>
					 <p>Артикул: <?= $product->art ?? ''; ?></p>

					 </span>
    </a>
    <?php if ($admin): ?>
        <div class="edit">
            <a href="/adminsc/product/edit/<?= $product->id ?>"><?= $edit ?></a>
        </div>
    <?php endif; ?>

</div>
