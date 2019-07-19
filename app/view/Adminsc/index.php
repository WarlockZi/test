<div class="wrap-admin">


  <div class="breadcrumbs-adm">
    <div>Админ</div>
  </div>
  
  
  <? if (in_array('3', $user['rightId'])): // admin ?>
     <div class="admin-actions">
       <a href  = "<?= PROJ ?>/adminsc/crm">CRM</a>
       <a href  = "<?= PROJ ?>/adminsc/catalog">Каталог товаров</a>
       <a href  = "<?= PROJ ?>/adminsc/settings">Настройки</a>
<!--       <a href  = "<?= PROJ ?>/adminsc/products">Товары</a>
       <a href  = "<?= PROJ ?>/adminsc/categories">Категории</a>
       <a href  = "<?= PROJ ?>/adminsc/orders">Заказы</a>
       <a href  = '<?= PROJ ?>/adminsc/users'>Пользователи</a>
       <a href  = '<?= PROJ ?>/adminsc/prodtypes'>Типы товаров</a>
       <a href  = '<?= PROJ ?>/adminsc/Sitemap'>Создать SiteMap</a>-->
     </div>
  <? endif; ?>
  

  <? if (in_array('4', $user['rightId'])):// SU ?> 
    
   <!--           <div id="vk_post_2083688_2227"></div><script type="text/javascript">
         (function (d, s, id) {
             var js, fjs = d.getElementsByTagName(s)[0];
             if (d.getElementById(id))
                 return;
             js = d.createElement(s);
             js.id = id;
             js.src = "//vk.com/js/api/openapi.js?152";
             fjs.parentNode.insertBefore(js, fjs);
         }(document, 'script', 'vk_openapi_js'));
         (function () {
             if (!window.VK || !VK.Widgets || !VK.Widgets.Post || !VK.Widgets.Post("vk_post_2083688_2227", 2083688, 2227, 'MBlZTbIB3sy975h0M9h5I5yNHE1D'))
                 setTimeout(arguments.callee, 50);
         }());
     </script>-->
  <? endif; ?>



</div>