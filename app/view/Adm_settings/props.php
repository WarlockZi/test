<div class="adm-submenu">



</div>


<div class="adm-content">
  <div class="breadcrumbs-adm">
    <a href  = "/adminsc">Admin</a>
    <a href  = "/adminsc/settings">Настройки</a>
    <div>Настройка свойств</div>
  </div>

  <div class="column">
    <div class="prop-head ">

      <H2 class="parent-prop">Настройка свойств</H2>

    </div>

    <div class="grid5 property-block">
      <input type="hidden" id="token" value="<?= $_SESSION['token'] ?>">
      <span class="grid-head">id</span>
      <span class="grid-head">сорт.</span>
      <span class="grid-head">название</span>
      <span class="grid-head">тип</span>
      <span class="grid-head">измен.</span>
      <? foreach ($catProps as $key): ?>


         <span>
           <span> <?=$id = $key['id'] ?>    </span>
         </span>
         <span>
           <span data-id = "<?=$id?>" class="sort" contenteditable> <?= $key['sort'] ?>    </span>
         </span>

         <span>
           <input data-id = "<?=$id?>" class="property-name" contenteditable size="35" type="text" value="<?= $key['name'] ?>">
         </span>

         <span>
           <select data-id = "<?=$id?>" class="type">
             <option value="select"<?= $key['type'] == 'select' ? 'selected' : '' ?>>выбор одного значения</option>
             <option value="multi"<?= $key['type'] == 'multi' ? 'selected' : '' ?>>выбор нескольких значений</option>
             <option value="string" <?= $key['type'] == 'string' ? 'selected' : '' ?>>строка</option>
           </select>
         </span>

         <span>
           <a href = "prop?id=<?=$id?>" data-id = "<?=$id?>" class="edit">
           </a>
         </span>
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