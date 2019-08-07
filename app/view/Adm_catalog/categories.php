<div class="adm-submenu">

  <?
  new app\view\widgets\menu\Menu([
      'class' => 'admin-category-menu',
      'tpl' => ROOT . "/app/view/widgets/menu/menu_tpl/site_admin_category_menu.php",
      'cache' => 60,
      'sql' => "SELECT * FROM category "
  ]);
  ?>

</div>


<div class="adm-content">
  <div class="breadcrumbs-adm">
    <a href  = "/adminsc/index">Admin</a>
    <a href  = "/adminsc/catalog">Каталог</a>
    <div>Категории товаров</div>
  </div>
</div>
