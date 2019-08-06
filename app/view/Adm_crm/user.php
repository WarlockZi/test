<div class="adm-submenu">
  <div class="title">CRM</div>
  <? if (in_array('3', $user['rightId'])): // admin ?>
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
    <div>User</div>
  </div>

  <div class="content-90">


    <div class="grid">
      <span><strong>id</strong></span>
      <span><strong>con</strong></span>
      <span><strong>email</strong></span>
      <span><strong>fio</strong></span>
      <span><strong>phone</strong></span>
      <span><strong>принят</strong></span>
      <span><strong>уволен</strong></span>
      <span><strong>д.р.</strong></span>


      <? foreach ($users as $use): ?>

         <span><?= $use['id']; ?></span>
         <span><?= $use['confirm']; ?></span>
         <span><?= $use['email']; ?></span>

         <span><a href="/adminsc/crm/user?id=<?= $use['id']; ?>"><?= $use['surName']; ?> <?= $use['name']; ?> <?= $use['middleName']; ?>    </a></span>
         <span><?= $use['phone']; ?> </span>
         <span>
             <?
             $date = date('Y-m-d', strtotime($use['hired']));
             $new_date_format = $date != '1970-01-01' ? $date : NULL;
             ?>
           <input type = 'date' class="hired" min="2016-08-14" max="2020-08-20" value = "<?= $new_date_format; ?>" >
         </span>
         <span>
             <? $new_date_format = date('Y-m-d', strtotime($use['fired'])) != '1970-01-01' ? date('Y-m-d', strtotime($use['fired'])) : NULL; ?>
           <input type = 'date' class="fired" min="2016-08-14" max="2020-08-20" value = "<?= $new_date_format ?>" >
         </span>
         <span>
             <? $new_date_format = date('Y-m-d', strtotime($use['birthDate'])) != '1970-01-01' ? date('Y-m-d', strtotime($use['birthDate'])) : NULL; ?>
           <input type = 'date' class="bday" min="2016-08-14" max="2020-08-20" value = "<?= $new_date_format ?>" >
         </span>
      <? endforeach; ?>

    </div>


    <button class = "btnadd-user">Создать нового</button>
  </div>



</div>
