<div class="adm-submenu">



</div>


<div class="adm-content">
  <div class="breadcrumbs-adm">
    <a href  = "/adminsc">Admin</a>
    <a href  = "/adminsc/settings">Настройки</a>
    <div>Свойства</div>
  </div>

  <div class="column">
    <div class="prop-head ">

      <div class="parent-prop">
        Свойства
      </div>
      <div class="add-prop">
        Добавить свойство
      </div>

    </div>


    <div class="property-block">
        <? foreach ($catProps as $key): ?>
         <div class="property" data-prop = '<?= $key['id'] ?>'>
           <input size="35" type="text" value="<?= $key['name'] ?>">

           <div class="prop">
             <div class="left-set">
               <input  name="type" type="radio" <?= $key['type'] == 'multy' ? 'checked' : '' ?>>
               <label class = 'multy'>выбор нескольких значений</label>
               <input  name="type" type="radio" <?= $key['type'] == 'multy' ? 'checked' : '' ?>>
               <label class = 'multy'>выбор одного значения</label>
               <input  name="type" type="radio" <?= $key['type'] == 'multy' ? 'checked' : '' ?>>
               <label class = 'multy'>строка</label>

             </div>
             <div class="val">
                 <? foreach ($key['val'] as $k): ?>
                  <div class="value" data-id = "<?= $key['id'] ?>" contenteditable="true">
                      <?= $k ?>
                  </div>
               <? endforeach; ?>
               <div class="add-prop-val clear button">+</div>
             </div>


           </div>

         </div>
      <? endforeach; ?>
    </div>



  </div>


  <div class="adm-save-cansel">
    <button>
      сохранить
    </button>
    <button>
      отменить
    </button>
  </div>

</div>