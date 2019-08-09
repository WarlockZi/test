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
    <div>User</div>
  </div>

  <div class="user content-90 column">

    <div>
      <strong>id:</strong><span><?= $user['id']; ?></span>
    </div>
    <div>
      <strong>подтвержден:</strong><span contenteditable="true"><?= $user['confirm']; ?></span>
    </div>
    <div>
      <strong>email:</strong><span contenteditable="true"><?= $user['email']; ?></span>
    </div>
    <div>
      <strong>фамилия:</strong><span contenteditable="true"><?= $user['surName']; ?> </span>
    </div>
    <div>
      <strong>имя:</strong><span contenteditable="true"><?= $user['name']; ?> </span>
    </div>
    <div>
      <strong>отчетсво:</strong><span contenteditable="true"><?= $user['middleName']; ?> </span>
    </div>
    <div>
      <strong>phone:</strong><span contenteditable="true"><?= $user['phone']; ?> </span>
    </div>
    <div>
      <strong>принят:</strong>
      <span>
          <?
          $date = date('Y-m-d', strtotime($user['hired']));
          $new_date_format = $date != '1970-01-01' ? $date : NULL;
          ?>
        <input type = 'date' class="hired" min="2016-08-14" max="2020-08-20" value = "<?= $new_date_format; ?>" >
      </span>
    </div>
    <div>
      <strong>уволен:</strong>
      <span>
          <? $new_date_format = date('Y-m-d', strtotime($user['fired'])) != '1970-01-01' ? date('Y-m-d', strtotime($use['fired'])) : NULL; ?>
        <input type = 'date' class="fired" min="2016-08-14" max="2020-08-20" value = "<?= $new_date_format ?>" >
      </span>
    </div>
    <div>
      <strong>д.р.:</strong>
      <span>
          <? $new_date_format = date('Y-m-d', strtotime($user['birthDate'])) != '1970-01-01' ? date('Y-m-d', strtotime($user['birthDate'])) : NULL; ?>
        <input type = 'date' class="bday" min="2016-08-14" max="2020-08-20" value = "<?= $new_date_format ?>" >
      </span>
    </div>
    <div>
      <strong></strong>
    </div>
    <div class="separator">
      <strong >ПРАВА: </strong>
      <strong></strong>
    </div>

    <? foreach ($rights as $right): ?>
       <div>
         <strong><?=
             $right['name'];
             $user_rights = explode(',', $user['rights']);
             ?> </strong>
         <input type="checkbox" <?= in_array($right['id'], $user_rights) ? 'checked' : '' ?>>
       </div>
<? endforeach; ?>







    <div class="separator btns">
      <button class = "btnadd-user">Создать нового</button>
      <button class = "btnupdate-user">Сохранить</button>
    </div>
  </div>



</div>
