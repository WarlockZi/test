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
    <div>Users</div>
  </div>

  <div class="content-90">
<!--    <div id = 'users'>
      <? foreach ($users as $use): ?>
         <div data-id = "<?= $use['id']; ?>" class="row pud">
           <div class = "column plr">id   <span><?= $use['id']; ?></span></div>
           <div class = "column plr">
             <span>conf</span>
             <input type = 'text' class="confirm" size="1" value = "<?= $use['confirm'] ?>">
           </div>
           <div>
             <input type = 'text' class="s-name" value = "<?= $use['surName'] ?>">
             <input type = 'text' class="name" value = "<?= $use['name'] ?>">
             <input type = 'text' class="m-name" value = "<?= $use['middleName'] ?>">
           </div>
           <div class="column plr">
             <span>email</span>
             <input type = 'text' class="email" value = "<?= $use['email'] ?>">
           </div>
           <div class="column plr">
             <span>phone</span>
             <input type = 'text' class="phone" value = "<?= $use['phone'] ?>">
           </div>
           <div class="column plr">           <span>принят</span>
               <?
               $date = date('Y-m-d', strtotime($use['hired']));
               $new_date_format = $date != '1970-01-01' ? $date : NULL;
               ?>
             <input type = 'date' class="hired" min="2016-08-14" max="2020-08-20" value = "<?= $new_date_format; ?>" >
           </div>
           <div class="column plr">
             <span>уволен</span>
             <? $new_date_format = date('Y-m-d', strtotime($use['fired'])) != '1970-01-01' ? date('Y-m-d', strtotime($use['fired'])) : NULL; ?>
             <input type = 'date' class="fired" min="2016-08-14" max="2020-08-20" value = "<?= $new_date_format ?>" >
           </div>
           <div class="column plr">
             <span>дата рожд.</span>
             <? $new_date_format = date('Y-m-d', strtotime($use['birthDate'])) != '1970-01-01' ? date('Y-m-d', strtotime($use['birthDate'])) : NULL; ?>
             <input type = 'date' class="bday" min="2016-08-14" max="2020-08-20" value = "<?= $new_date_format ?>" >
           </div>
           <div id = '<?= $i ?>' class="edit buttons"> редакт</div>
         </div>
      <? endforeach; ?>
    </div>-->


    <div class="grid">

      <span><strong>con</strong></span>
      <span><strong>email</strong></span>
      <span><strong>fio</strong></span>




      <? foreach ($users as $use): ?>

         <span><?= $use['confirm']; ?></span>
         <span><?= $use['email']; ?></span>

         <span><a href="/adminsc/crm/user?id=<?= $use['id']; ?>"><?= $use['surName']; ?> <?= $use['name']; ?> <?= $use['middleName']; ?>    </a></span>
<!--         <span><?= $use['phone']; ?> </span>
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
         </span>-->
      <? endforeach; ?>

    </div>


    <button class = "btnadd-user">Создать нового</button>
  </div>



</div>
