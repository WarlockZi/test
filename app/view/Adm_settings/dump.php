<div class="wrap-admin">


  <div class="breadcrumbs-adm">
    <a href  = "index">Настройки</a>
    <div>Резервное копирование</div>
  </div>


  <? if (in_array('3', $user['rights'])): // admin ?>
     <div class="admin-actions">

       <a href  = '/adminsc/settings/dumpwww'>Dump WWW</a>
       <a href  = '/adminsc/settings/dumpsql'>Dump SQL</a>
     </div>
  <? endif; ?>





</div>