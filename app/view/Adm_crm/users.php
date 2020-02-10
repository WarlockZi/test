<div class="adm-submenu">
  <div class="title">CRM</div>
  <? if (in_array('3', $user['rights'])): // admin ?>
     <div class="admin-actions">

       <a href  = "crm/orders">Заказы</a>
       <a href  = 'users'>Покупатели</a>

     </div>
  <? endif; ?>
</div>

<div class="adm-content">
  <div class="breadcrumbs-adm">
    <a href  = "/adminsc">Admin</a>
    <a href  = "/adminsc/crm">CRM</a>
    <div>Users</div>
  </div>

  <div class="content-90">
    <div class="grid">

      <span><strong>fio</strong></span>
      <span><strong>con</strong></span>
      <span><strong>email</strong></span>




      <? foreach ($users as $use): ?>

         <span><a href="/adminsc/crm/user?id=<?= $use['id']; ?>"><?= $use['surName']; ?> <?= $use['name']; ?> <?= $use['middleName']; ?>    </a></span>
         <span><?= $use['confirm']; ?></span>
         <span><?= $use['email']; ?></span>

      <? endforeach; ?>

    </div>


    <button class = "btnadd-user">Создать нового</button>
  </div>



</div>
