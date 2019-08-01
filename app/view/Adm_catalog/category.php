<div class="wrap-admin">

  <div class="breadcrumbs-adm">
    <a href  = "/adminsc/index">Admin</a>
    <a href  = "/adminsc/catalog">Каталог</a>
    <a href  = "/adminsc/catalog/categories">Категории товаров</a>
  </div>
  <div class="nav-catalog breadcrumbs-adm">
      <? if (isset($category['parents'])): ?>
         <? foreach ($category['parents'] as $k => $v): ?>
    <a href  = "/adminsc/catalog/category?id=<?= $v['id'] ?>"><?= $v['name'] ?></a><span><?= $v['title'] ?></span>
       <? endforeach; ?>
    <? endif; ?>
    <div data-id = <?= $category['id'] ?>><?= $category['title'] ?></div>
  </div>

  <div class="wrap-admin">
    <div class="work-area">

      <div class="tabs">
        <input id="tab1" type="radio" name="tabs" checked>
        <label for="tab1" title="Вкладка 1">Подкатегории</label>
        <input id="tab2" type="radio" name="tabs">
        <label for="tab2" title="Вкладка 2">Свойства</label>
        <input id="tab3" type="radio" name="tabs">
        <label for="tab3" title="Вкладка 3">Сео</label>
        <input id="tab4" type="radio" name="tabs">
        <label for="tab4" title="Вкладка 4">Подробно</label>



        <section id="content-tab1">
          <div class="left-menu column">
              <? foreach ($category['children'] as $key => $value) : ?>
               <a href="/adminsc/catalog/category?id=<?= $value['id'] ?>"><?= $value['alias'] ?></a>
            <? endforeach; ?>
          </div>
        </section>

        <section id="content-tab2">

          <div class="column">
              <? if (isset($category['parents'])): ?>
                 <? foreach ($category['parents'] as $k): ?>
                  <div class="parent-properties">
                      <? app\core\App::$app->category->getCatPropsValsSnip($k['props']); ?>
                  </div>
               <? endforeach; ?>
                 <? unset($category['parents']) ?>
            <? endif; ?>
               <div class="properties">
                   <? app\core\App::$app->category->getCatPropsValsSnip($category['props']); ?>
               </div>
          </div>


        </section>
        <section id="content-tab3">



        </section>
        <section id="content-tab4">



        </section>
      </div>

    </div>
  </div>

</div>