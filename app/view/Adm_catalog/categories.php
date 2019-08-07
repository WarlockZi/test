<div class="adm-submenu">
    <label for="category"  >Категории
    <input type="checkbox" class="title" id="category">
    </label>
    

    <div class="column categories">
        <? foreach ($iniCatList as $key => $value) : ?>
         <a class="row" href="/adminsc/catalog/category?id=<?= $value['id'] ?>">
           <span><?= $value['name'] ?></span>
         </a>
      <? endforeach; ?>

  </div>

</div>
<div class="adm-content">
  <div class="breadcrumbs-adm">
    <a href  = "/adminsc/index">Admin</a>
    <a href  = "/adminsc/catalog">Каталог</a>
    <div>Категории товаров</div>
  </div>
</div>
