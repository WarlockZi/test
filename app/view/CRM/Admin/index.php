  <? if (\app\core\Auth::getUser()->can()):// SU ?>
     <input class = "list" type="button" name="scr" id="scr" value = "выгрузить ">
     <form method="post" action= '/Adminsc/FileImport'>
       <input class = "list" type="submit" name = 'scrImport' value = "загрузить ">
     </form>

     <form method="post" action= '/Adminsc/ProductsActivity'>
       <input class = "list" type="submit" name = 'ProductsActivity' value = "actionProductsActivity ">
     </form>

     <a class = "list" href  = '/adminsc/galery'>Картинки</a>


     <form method="post" action= '/Adminsc'>
       <input class = "list" type="submit" name = 'cat' value = "Формируем категории">
     </form>
     <form method="post" action= '/Adminsc'>
       <input class = "list" type="submit" name = 'translitCat' value = "Категории транслит">
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



