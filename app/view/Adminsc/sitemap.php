<div class="wrap-admin">


  <div class="breadcrumbs-adm">
    <a href  = "index">Admin</a>
    <div>Site Map</div>
  </div>

  <div class="work-area">

    <? if (in_array('3',$user['rights'])): // admin ?>
       <div class="admin-actions">
         <div>Создать sitemap</div>
       </div>
    <? endif; ?>

    <div class="work-middle">
      <lable for = 'file-name'>Имя файла: 
        <input name = 'file-name' type="text">
      </lable> 
      <button id='create_sitemap'>Создать карту</button>
    </div>    

  </div>




</div>