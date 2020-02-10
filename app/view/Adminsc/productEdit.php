<div class = 'wrap-admin'>
  <div class = 'admin-product-edit'>
    <div class="title">
      <div contenteditable="true"><?= $product['name'] ?></div>
    </div>
    <div class="main">

      <div class="tabs">
        <input id="tab1" type="radio" name="tabs" checked>
        <label for="tab1" title="Вкладка 1">Товар</label>

        <input id="tab2" type="radio" name="tabs">
        <label for="tab2" title="Вкладка 2">Анонс</label>

        <input id="tab3" type="radio" name="tabs">
        <label for="tab3" title="Вкладка 3">Подробно</label>

        <input id="tab4" type="radio" name="tabs">
        <label for="tab4" title="Вкладка 4">Сео</label>

        <section id="content-tab1">

          <div class="flex">
            <div class="img-box">
              <img  src="<?= "/pic" . $product['dpic'] ?>"></img>
            </div>


            <div class="props">
              <div class="prop">
                <div class="key">Артикул:</div>
                <div class="val" contenteditable="true"> <?= $product['art'] ?></div>
              </div>

              <? foreach ($categoryProps as $k): ?>
                 <div class="prop">
                   <div class="key"><?= $k['name'] ?>:</div>
                   <select class="val" name="" id="">
                       <? $val = explode(',', $k['val']); ?>
                     <option  value=""></option>
                     <? foreach ($val as $d): ?>
                        <option  value="<?= $d ?>"><?= $d ?></option>
                     <? endforeach; ?>
                   </select>
                   <? if ($k['type'] == 'multy'): ?>
                      <div class="add">Добавить</div>
                   <? endif; ?>
                   <!--<div class="art" contenteditable="true"> <?= $k['name'] ?></div>-->
                 </div>
              <? endforeach; ?>

            </div>



          </div>

        </section>
        <section id="content-tab2">

          <div class="flex">

            <div class="art">Артикул: <?= $product['art'] ?></div>
          </div>


        </section>
        <section id="content-tab3">



        </section>

        <section id="content-tab4">

          <div class="prop">
            <div class="key">title:</div>
            <div class="val" contenteditable="true"> <?= $product['title'] ?></div>
          </div>
          <div class="prop">
            <div class="key">description:</div>
            <div class="val" contenteditable="true"> <?= $product['description'] ?></div>
          </div>
          <div class="prop">
            <div class="key">keywords:</div>
            <div class="val" contenteditable="true"> <?= $product['keywords'] ?></div>
          </div>


        </section>
      </div>


      <div class="props">


      </div>
    </div>
  </div>
</div>