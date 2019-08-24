<div class="adm-submenu">
  <div class="title">Каталог</div>
  <div class="admin-actions">
      <?

      use \app\core\Base\View;

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
          <a href  = "/adminsc/catalog/category?id=<?= View::e($v['id']) ?>"><?= View::e($v['name']) ?></a>
       <? endforeach; ?>
       <div><?= View::e($category['name']); ?></div>
     </div>
     <!--<div class="nav-catalog breadcrumbs-adm">-->

  <? endif; ?>

  <div class="wrap-admin">
    <div class="work-area">
      <input id = 'token' type="hidden" value="<?= $_SESSION['token'] ?>">

      <div class="tabs">
        <input id="tab1" type="radio" name="tabs" checked>
        <label for="tab1" title="Подкатегории">Подробно</label>
        <input id="tab2" type="radio" name="tabs">
        <label for="tab2" title="Свойства">Свойства</label>
        <input id="tab3" type="radio" name="tabs">
        <label for="tab3" title="Сео">Сео</label>
        <input id="tab4" type="radio" name="tabs">
        <label for="tab4" title="Подробно">Подкатегории</label>



        <section id="content-tab1" class="user content-90 column">
          <div>
            <strong>id :</strong>
            <span contenteditable id = 'id'><?= $category['id'] ?: ''; ?></span>
          </div>
          <div>
            <strong>Наименование :</strong>
            <span contenteditable id = 'name'><?= $category['name'] ?: ''; ?></span>
          </div>
          <div>
            <strong>url :</strong>
            <span contenteditable id = 'alias'><?= $category['alias'] ?: ''; ?></span>
          </div>
          <div>
            <strong>Описание :</strong>
            <span contenteditable id = 'text' class="column"><?= htmlspecialchars($category['text'] ?: ''); ?></span>
          </div>



        </section>

        <section id="content-tab2">

          <? if (isset($category['parents'])): ?>
             <? foreach ($category['parents'] as $parentCat): ?>
                <div class="parent-properties separator">Свойства родительской категории</div>
                <div class="parent-prop column">
                    <? foreach ($parentCat['props'] as $Pprop): ?>
                     <div class="category-properties">
                         <? foreach ($props as $prop): ?>
                            <? if ($Pprop == $prop['id']): ?>
                               <?= $prop['name'] ?>
                            <? endif; ?>
                         <? endforeach; ?>
                     </div>
                  <? endforeach; ?>
                </div>
             <? endforeach; ?>
          <? endif; ?>

          <div class="properties column">
            <div class="cat-prop">
              Свойства категории
            </div>

            <? foreach ($category['props'] as $k => $catProp): ?>

               <select>
                 <option value=""></option>
                 <? foreach ($props as $prop): ?>
                    <? if (!in_array($prop['id'], $category['parentProps'])): ?>
                       <option value="<?= $prop['id']; ?>" <?= $catProp == $prop['id'] ? 'selected' : ''; ?>><?= $prop['name'] ?></option>
                    <? endif; ?>
                 <? endforeach; ?>
               </select>

            <? endforeach; ?>

            <select class = 'new-prop'>

              <option value=""></option>

              <? foreach ($props as $prop): ?>
                 <? if (!in_array($prop['id'], $category['parentProps']) && !in_array($prop['id'], $category['props'])): ?>
                    <option value="<?= $prop['id']; ?>" <?= $catProp == $prop['id'] ? 'selected' : ''; ?>><?= $prop['name'] ?></option>
                 <? endif; ?>
              <? endforeach; ?>

            </select>


            <div class="add-property row" >

            </div>

          </div>


        </section>

        <section id="content-tab3" class="user content-90 column">

          <div>
            <strong>title :</strong>
            <span contenteditable id = 'title'><?= $category['title'] ?: ''; ?></span>
          </div>
          <div>
            <strong>key words :</strong>
            <span contenteditable id = 'keywords'><?= $category['keywords'] ?: ''; ?></span>
          </div>
          <div>
            <strong>description :</strong>
            <span contenteditable id = 'description'><?= $category['description'] ?: ''; ?></span>
          </div>
          <div>
            <strong>семантическое ядро :</strong>
            <span contenteditable id = 'core'><?= $category['core'] ?: ''; ?></span>
          </div>


        </section>

        <section id="content-tab4">
          <div class="left-menu column">
              <? if (isset($category['children']['categories'])): ?>
                 <? foreach ($category['children']['categories'] as $key => $value) : ?>
                  <a href="/adminsc/catalog/category?id=<?= $value['id'] ?>"><?= $value['alias'] ?></a>
               <? endforeach; ?>
            <? endif; ?>
          </div>


        </section>
        <div class="separator btns">
          <button class="category-update-btn">Сохранить
          </button>
          <button class="category-create-btn">Добавить категорию
          </button>
        </div>
      </div>
    </div>

  </div>
</div>