<div class="site">

  <? foreach ($products as $product): ?>
  <div class="badge">
    <p><?= $product['id']; ?></p>
    <img src="/pic<?= $product['prevPic']; ?>" alt="">
    <a href="<?= $product['durl']; ?>"><?= $product['name']; ?></a>
    <!--<p><?//= $product['dtxt']; ?></p>-->
    </div>
<? endforeach; ?>

</div>