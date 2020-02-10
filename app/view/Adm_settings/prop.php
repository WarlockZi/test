<div class="adm-submenu">
</div>


<div class="adm-content">
  <div class="breadcrumbs-adm">
    <a href  = "/adminsc">Admin</a>
    <a href  = "/adminsc/settings">Настройки</a>
    <a href  = "/adminsc/settings/props">Свойства</a>
    <div>Настройка свойств</div>
  </div>

  <div class="column">

    <H2 style='margin:20px 0;'>Настройка значений свойствa : <?= $prop['name'] ?></H2>


    <input type="hidden" id="token" value="<?= $_SESSION['token'] ?>">

    <? if ($prop['type'] == 'string'): ?>
       <div class="grid-prop-string">

         <span class="grid-head">имя</span>
         <span class="grid-head">ед. измерения</span>

         <span data-id = <?= $prop['id'] ?> ><?= $prop['name']; ?></span>
         <span id = 'piece' data-id = <?= $prop['id'] ?> contenteditable><?= $prop['piece']; ?></span>

       </div>

       <div class="separator btns">
         <button id = 'save' data-id = '<?= $prop['id'] ?>'>
           сохранить
         </button>
       </div>

    <? else: ?>
       <div class="grid">
         <span class="grid-head">id</span>
         <span class="grid-head">значение</span>
         <span class="grid-head">.</span>
         <? foreach ($prop['val'] as $key => $val): ?>
            <span></span>
            <span data-id = <?= $prop['id'] ?> contenteditable><?= $val; ?> </span>
            <span></span>
         <? endforeach; ?>
         <span></span>
         <span data-id = <?= $prop['id'] ?> contenteditable class="new"></span>
         <span></span>
       </div>
    <? endif; ?>


  </div>
  </div>




