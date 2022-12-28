

<main>
  <div class="site">
    <nav class="breadcrumbs">
        <?= $breadcrumbs ?>
    </nav>

    <div class="products">
        <? foreach ($products as $product): ?>
           <? if ($product["act"] === "Y"): ?>
            <div class="product-container"  ontouchstart="this.classList.toggle('hover');">
              <a class = "link" href="/catalog<?= $prodName = $product['durl']; ?>" aria-label="<?= $prodName; ?>">
              </a>

              <div class="product">
                <div class="product-front" <?= "/" ?>>
                  <div class="img-container">
                    <img src="<?= $product['dpic'] ? '/pic' : '/pic/srvc/nophoto-min.jpg' ?><?= $product['dpic']; ?>" alt="<?= $product['name']; ?>">
                  </div>
                  <a href="/catalog<?= $product['durl']; ?>"><?= $product['name']; ?></a>
                </div>
                <div class="product-back">
                  <p><?= $product['dtxt']; ?></p>
                  <span>читать подробнее</span>
                </div>
              </div>

            </div>
         <? endif; ?>
      <? endforeach; ?>
    </div>
  </div>
</main>
