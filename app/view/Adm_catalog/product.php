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
       <a href  = "/adminsc/catalog/category?id=<?= $category['id'] ?>"><?= $category['name']?:'' ?></a>
       <div><?= $product?$product['name']?:'Новый':'Новый'; ?></div>

    <? endif; ?>
  </div>
  <H1><?= $product?$product['name']?:'':'Новый'; ?></H1>

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
                <span id = 'id' <?= $product?$product['id']?:'':'new' ?: ''; ?>><?= $product?$product['id']?:'':'new' ?: ''; ?></span>
              </div>
              <div class = 'prop row'>
                <strong>Показать на сайте  :</strong>
                <span>
                  <input type="checkbox" id = 'act' <?= $product ? $product['act'] == 'Y' ? 'ckecked' : '': 'ckecked'; ?>>

                </span>
              </div>
              <div class = 'prop row'>
                <strong>Наименование :</strong>
                <span contenteditable id = 'name'><?= $product?$product['name'] ?: '':''; ?></span>
              </div>

            </div>
            <div class="right  column">
              <div>
                <img id = 'dpic' dpic = '/pic<?= $product ? $product['dpic'] ?: '':''; ?>' src = '/pic<?=  $product?$product['dpic'] ?: '':'/srvc/nophoto-min.jpg'; ?>'>
              </div>
            </div>
          </div>

          <div>
            <strong>Описание :</strong>
            <span contenteditable id = 'text' class="column"><?= $product?$product['dtxt'] ?: '':''; ?></span>
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
              <span contenteditable id = 'title'><?= $product?$product['title'] ?: '':''; ?></span>
            </div>
            <div class = 'row'>
              <strong>url :</strong>
              <span contenteditable id = 'alias'><?= $product?$product['alias'] ?: '':''; ?></span>
            </div>
            <div class="row">
              <strong>ключевые слова :</strong>
              <span contenteditable id = 'keywords'><?= $product?$product['keywords'] ?: '':''; ?></span>
            </div>
            <div class="row">
              <strong>сниппет для поисковиков :</strong>
              <span contenteditable id = 'description'><?= $product?$product['description'] ?: '':''; ?></span>
            </div>
            <div class="row">
              <strong>семантическое ядро :</strong>
              <span contenteditable id = 'core'><?= $product?$product['core'] ?: '':''; ?></span>
            </div>
          </div>


        </section>

        <section id="content-tab4">

          <div class="row separator">основная картинка</div>

          <div class="row">
            <div class="load-pic holder column">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 30" width="132px" height="122" style=""><path fill="#bdebee" d="M25.913 8.143c-.438-4.563-4.237-8.143-8.914-8.143-3.619 0-6.718 2.148-8.146 5.23-.43-.137-.878-.23-1.353-.23-2.485 0-4.5 2.016-4.5 4.5 0 .494.099.961.246 1.404-1.933 1.127-3.246 3.196-3.246 5.594 0 3.59 2.91 6.5 6.5 6.5v.002h17.999v-.002c4.144 0 7.499-3.357 7.499-7.5 0-3.656-2.62-6.693-6.085-7.355zm-6.134 5.757h-1.78v4.012c0 .553-.446 1.002-1 1.002h-2c-.552 0-1-.449-1-1.002v-4.012h-1.781c-1.086 0-1.529-.725-.987-1.609l3.781-3.727c.741-.74 1.21-.765 1.974 0l3.781 3.727c.544.885.098 1.609-.988 1.609z"></path></svg>
              <input id=choose-main-pic type="file">
              <label for="choose-main-pic">Выбрать файл</label>
            </div>

            <div class="pic w200 h200">
              <img src="/pic<?= $product?$product['dpic'] ?: '/pic/srvc/nophoto-min.jpg':'/srvc/nophoto-min.jpg'; ?>" alt="">
            </div>

          </div>

          <div class="row separator">дополнительные картинки</div>

          <div class="row">
            <div class="load-pic holder column">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 30" width="132px" height="122" style=""><path fill="#bdebee" d="M25.913 8.143c-.438-4.563-4.237-8.143-8.914-8.143-3.619 0-6.718 2.148-8.146 5.23-.43-.137-.878-.23-1.353-.23-2.485 0-4.5 2.016-4.5 4.5 0 .494.099.961.246 1.404-1.933 1.127-3.246 3.196-3.246 5.594 0 3.59 2.91 6.5 6.5 6.5v.002h17.999v-.002c4.144 0 7.499-3.357 7.499-7.5 0-3.656-2.62-6.693-6.085-7.355zm-6.134 5.757h-1.78v4.012c0 .553-.446 1.002-1 1.002h-2c-.552 0-1-.449-1-1.002v-4.012h-1.781c-1.086 0-1.529-.725-.987-1.609l3.781-3.727c.741-.74 1.21-.765 1.974 0l3.781 3.727c.544.885.098 1.609-.988 1.609z"></path></svg>
              <input id="choose-main-pic" type="file">
              <label for="choose-main-pic">Выбрать файл</label>
            </div>

            <div class="pic w200 h200">
            </div>

          </div>

          <div class="row separator">расцветки</div>

          <div class="row">
            <div class="load-pic holder column">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 30" width="132px" height="122" style=""><path fill="#bdebee" d="M25.913 8.143c-.438-4.563-4.237-8.143-8.914-8.143-3.619 0-6.718 2.148-8.146 5.23-.43-.137-.878-.23-1.353-.23-2.485 0-4.5 2.016-4.5 4.5 0 .494.099.961.246 1.404-1.933 1.127-3.246 3.196-3.246 5.594 0 3.59 2.91 6.5 6.5 6.5v.002h17.999v-.002c4.144 0 7.499-3.357 7.499-7.5 0-3.656-2.62-6.693-6.085-7.355zm-6.134 5.757h-1.78v4.012c0 .553-.446 1.002-1 1.002h-2c-.552 0-1-.449-1-1.002v-4.012h-1.781c-1.086 0-1.529-.725-.987-1.609l3.781-3.727c.741-.74 1.21-.765 1.974 0l3.781 3.727c.544.885.098 1.609-.988 1.609z"></path></svg>
              <input id=choose-main-pic type="file">
              <label for="choose-main-pic">Выбрать файл</label>
            </div>

            <div class="pic w200 h200">
            </div>

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