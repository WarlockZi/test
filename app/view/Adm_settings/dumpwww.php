<div class="wrap-admin">


  <div class="breadcrumbs-adm">
    <a href  = "/adminsc">Admin</a>
    <a href  = "index">Настройки</a>
    <a href  = "dump">Dump</a>
    <div>Скопировать WWW</div>
  </div>


  <? if (in_array('3', $user['rightId'])): // admin ?>
     <form class = 'column dump-form' action="/adminsc/settings/dumpwww">


       <label class ='row' for="name" value = >file name<input id = "name" type="text" VALUE = <?= $_SERVER['DOCUMENT_ROOT'] ?>>
       </label>
       
       
       <input type="submit" value = 'вперед'>

     </form>


  <? endif; ?>





</div>