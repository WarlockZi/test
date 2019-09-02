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
    <div class="prop-head ">

      <div class="parent-prop">Настройка значений свойствa : <?= $prop['name'] ?></div>

    </div>

    <div class="grid property-block">
      <input type="hidden" id="token" value="<?= $_SESSION['token'] ?>">
      <span class="grid-head">№</span>
      <span class="grid-head">имя</span>
      <span class="grid-head">.</span>
      <? foreach ($prop['val'] as $key => $val): ?>
         <span></span>

         <span data-id = <?=$prop['id']?> contenteditable><?= $val; ?> </span>

         <span></span>

      <? endforeach; ?>
      <span></span>
      <span data-id = <?=$prop['id']?> contenteditable class="new"></span>
      <span></span>

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