<div class="adm-submenu">
  <div class="title">Каталог</div>

  <div class="admin-actions">
      <?
      new app\view\widgets\menu\Menu([
          'class' => 'admin-category-menu',
          'tpl' => ROOT . "/app/view/widgets/menu/menu_tpl/site_admin_category_menu.php",
          'cache' => 60,
          'sql' => "SELECT * FROM category "
      ]);
      ?>
    <a href  = "/adminsc/catalog/products">Товары</a>
  </div>
</div>

<div class="adm-content">

  <div class="breadcrumbs-adm">
    <a href  = "/adminsc/index">Admin</a>
    <div>Каталог</div>
  </div>



</div>
