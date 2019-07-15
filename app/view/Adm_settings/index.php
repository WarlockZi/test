<div class="wrap-admin">


  <div class="breadcrumbs-adm">
    <a href  = "index">Admin</a>
    <div>Настройки</div>
  </div>


  <? if (in_array('3', $user['rightId'])): // admin ?>
     <div class="admin-actions">

       <a href  = '<?= PROJ ?>/adminsc/Sitemap'>Создать SiteMap</a>
       <a href  = #>Права пользователей</a>
       <a href  = #>Должности пользователей</a>
       <a href  = '/adminsc/settings/props'>Свойства (товаров, пользователей)</a>
       <a href  = '/adminsc/settings/instructions'>Инструкции</a>
       <a href  = '/adminsc/settings/dump'>Dump</a>
       <a href  = '/adminsc/settings/pics'>Картинки</a>

     </div>
  <? endif; ?>


  <? if (in_array('4', $user['rightId'])):// SU ?> 
     <input class = "list" type="button" name="scr" id="scr" value = "выгрузить ">
     <form method="post" action= '<?= PROJ ?>/Adminsc/FileImport'>
       <input class = "list" type="submit" name = 'scrImport' value = "загрузить ">
     </form>

     <form method="post" action= '<?= PROJ ?>/Adminsc/ProductsActivity'>
       <input class = "list" type="submit" name = 'ProductsActivity' value = "actionProductsActivity ">
     </form>

     <a class = "list" href  = '<?= PROJ ?>/adminsc/galery'>Картинки</a>


     <form method="post" action= '<?= PROJ ?>/Adminsc'>
       <input class = "list" type="submit" name = 'cat' value = "Формируем категории">
     </form>
     <form method="post" action= '<?= PROJ ?>/Adminsc'>
       <input class = "list" type="submit" name = 'translitCat' value = "Категории транслит">
     </form>        

     <form method="post" action= '/Adminsc'>
       <input class = "list" type="submit" name = 'replaceUnderlinesDashesInURLS' value = "Заменить _ дефисами">
     </form> 
     <form method="post" action= '/Adminsc'>
       <input class = "list" type="submit" name = 'fixProductsPath' value = "Замена пути товаров">
     </form> 
     <form method="post" action= '/Adminsc'>
       <input class = "list" type="submit" name = 'fixPicNames' value = "Замена арт картинки">
     </form> 
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