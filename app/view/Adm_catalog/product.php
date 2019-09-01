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
  </div>
</div>
<div class="adm-content">
  <div class="breadcrumbs-adm">
    <a href  = "/adminsc/index">Admin  ></a>
    <a href  = "/adminsc/catalog">Каталог  ></a>

    <? if (isset($category['parents'])): ?>
       <? foreach ($category['parents'] as $k => $v): ?>
          <a href  = "/adminsc/catalog/category?id=<?= $v['id'] ?>"><?= $v['name'] ?></a>
       <? endforeach; ?>
       <a href  = "/adminsc/catalog/category?id=<?= $category['id'] ?>"><?= $category['name'] ?></a>
       <div><?= $product['name']; ?></div>

    <? endif; ?>
  </div>
  <H1><?= $product['name']; ?></H1>

  <div class="wrap-admin">
    <div class="work-area">
      <input id = 'token' type="hidden" value="<?= $_SESSION['token'] ?>">
      <div class="tabs">
        <input id="tab1" type="radio" name="tabs" checked>
        <label for="tab1" title="Подробно">Подробно</label>
        <input id="tab2" type="radio" name="tabs">
        <label for="tab2" title="Свойства">Свойства</label>
        <input id="tab3" type="radio" name="tabs">
        <label for="tab3" title="Сео">Сео</label>
        <input id="tab4" type="radio" name="tabs">
        <label for="tab4" title="Картинки">Картики</label>



        <section id="content-tab1" class="prod-details column">
          <div class="row">
            <div class="left column">
              <div class = 'prop row'>
                <strong>id :</strong>
                <span id = 'id' <?= $product['id'] ?: ''; ?>><?= $product['id'] ?: ''; ?></span>
              </div>
              <div class = 'prop row'>
                <strong>Активный  :</strong>
                <input type="checkbox" id = 'act' <?= $product['act']=='Y' ?'ckecked': ''; ?>>
              </div>
              <div class = 'prop row'>
                <strong>Наименование :</strong>
                <span contenteditable id = 'name'><?= $product['name'] ?: ''; ?></span>
              </div>
              <div class = 'prop row'>
                <strong>url :</strong>
                <span contenteditable id = 'alias'><?= $product['alias'] ?: ''; ?></span>
              </div>
            </div>
            <div class="right  column">
              <div>
                <img src = "<?= '/pic' . $product['dpic'] ?: ''; ?>">
              </div>
            </div>
          </div>

          <div>
            <strong>Описание :</strong>
            <span contenteditable id = 'text' class="column"><?= $product['dtxt'] ?: ''; ?></span>
          </div>



        </section>

        <section id="content-tab2">



          <div class="properties column">
            <H1 class="prod-prop">Свойства товара</H1>

            <?
            if (isset($category['parents'])) {
               $category['props'] = array_merge($category['parentProps'], $category['props']);
            }
            ?>

            <div class="product-prop column">
                <? foreach ($category['props'] as $Pprop): ?>
                 <div class="category-properties">
                     <? foreach ($props as $prop): ?>
                        <? if ($Pprop == $prop['id']): ?>
                         <span><?= $prop['name'] ?></span>

                         <? if ($prop['type'] == 'string') : ?>
                            <input value="<?= is_array($product['props']) && array_key_exists($Pprop, $product['props']) ? $product['props'][$Pprop] : '' ?>" data-type = 'text' data-id="<?= $prop['id']; ?>" contenteditable type="text">


                         <? elseif ($prop['type'] == 'select'): ?>
                            <? $val = explode(',', $prop['val']); ?>
                            <select data-type = 'select' data-id="<?= $prop['id']; ?>">
                              <option value=""></option>
                              <? foreach ($val as $i => $p): ?>
                                 <option <?= is_array($product['props']) && array_key_exists($Pprop, $product['props']) && ($i == $product['props'][$Pprop]) ? 'selected' : ''; ?> value="<?= $i; ?>"><?= $p; ?></option>
                              <? endforeach; ?>
                            </select>


                         <? elseif ($prop['type'] == 'multi'): ?>
                            <? $val = explode(',', $prop['val']); ?>
                            <select data-type = 'multi-select' data-id="<?= $prop['id']; ?>" multiple title = "для выбора нескольких значений зажмите 'CTRL'" name="" id="">
                                <? foreach ($val as $i => $p): ?>
                                   <? $multi = explode(',', $product['props'][$Pprop]); ?>
                                 <option value="<?= $i; ?>" <?= is_array($product['props']) && array_key_exists($Pprop, $product['props']) && (array_key_exists($i, $multi)) ? 'selected' : '' ?>><?= $p; ?></option>
                              <? endforeach; ?>
                            </select>

                         <? endif; ?>

                      <? endif; ?>
                   <? endforeach; ?>
                 </div>
              <? endforeach; ?>
            </div>


            <div class="add-property row" >

            </div>

          </div>


        </section>

        <section id="content-tab3">

          <div class="admin-flex-table">
            <div class="row">
              <strong>название вкладки :</strong>
              <span contenteditable id = 'title'><?= $product['title'] ?: ''; ?></span>
            </div>
            <div class="row">
              <strong>ключевые слова :</strong>
              <span contenteditable id = 'keywords'><?= $product['keywords'] ?: ''; ?></span>
            </div>
            <div class="row">
              <strong>сниппет для поисковиков :</strong>
              <span contenteditable id = 'description'><?= $product['description'] ?: ''; ?></span>
            </div>
            <div class="row">
              <strong>семантическое ядро :</strong>
              <span contenteditable id = 'core'><?= $product['core'] ?: ''; ?></span>
            </div>
          </div>


        </section>

        <section id="content-tab4">
          <div class="left-menu column">
              <? if (isset($product['children']['categories'])): ?>
                 <? foreach ($product['children']['categories'] as $key => $value) : ?>
                  <a href="/adminsc/catalog/category?id=<?= $value['id'] ?>"><?= $value['alias'] ?></a>
               <? endforeach; ?>
            <? endif; ?>
          </div>


        </section>
        <div class="separator btns">
          <button id="product-update-btn">Сохранить
          </button>
          <button id="product-create-btn">Добавить категорию
          </button>
        </div>
      </div>
    </div>

  </div>
</div>