<div class="wrap-admin">


  <div class="breadcrumbs-adm">
    <a href  = "/adminsc">Admin</a>
    <a href  = "/adminsc/settings">Настройки</a>
    <div>Инструкции</div>
  </div>


  <div class="admin-instructions row">
      <? if (in_array('3', $user['rights'])): // admin ?>
         <? if (isset($roles)): ?>
          <div class="admin-actions">
              <? foreach ($roles as $key => $value) : ?>
               <a href="<?= $value ?>"><?= $key ?></a>
            <? endforeach; ?>

          </div>
       <? endif; ?>

       <? if (isset($doc)): ?>

          <div class="doc row" contenteditable="">
              <?= $doc['text']; ?>
          </div>

       <? endif; ?>
    <? endif; ?>
    <? if (isset($modules)): ?>
       <div class="column">
         <? foreach ($modules as $key) : ?>
            <a href="/adminsc/settings/instructions/module/<?= $key['id'] ?>"><?= $key['name'] ?></a>
         <? endforeach; ?>
       </div>
    <? endif; ?>
  </div>




</div>