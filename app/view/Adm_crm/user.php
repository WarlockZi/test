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
    <a href  = "/adminsc/crm/users">Users</a>
    <div>User</div>
  </div>

  <div class="user content-90 column">

    <div>
      <strong>id :</strong><span id ='id'><?= $user['id']; ?></span>
    </div>
    <div>
      <strong>подтвержден :</strong>
      <select name="conf" id="conf" value = 1>
          <option value="0" <?= $user['confirm']=='0'?'selected':''; ?>>0</option>
          <option value="1" <?= $user['confirm']=='1'?'selected':''; ?>>1</option>
      </select>
    </div>
    <div>
      <strong>email :</strong><span id ='email' contenteditable="true"><?= $user['email']; ?></span>
    </div>
    <div>
      <strong>фамилия :</strong><span id ='s-name' contenteditable="true"><?= $user['surName']; ?> </span>
    </div>
    <div>
      <strong>имя :</strong><span id ='name' contenteditable="true"><?= $user['name']; ?> </span>
    </div>
    <div>
      <strong>отчетсво:</strong><span id ='m-name' contenteditable="true"><?= $user['middleName']; ?> </span>
    </div>
    <div>
      <strong>phone:</strong><span id ='phone' contenteditable="true"><?= $user['phone']; ?> </span>
    </div>
    <div>
      <strong>добавочный:</strong><span id ='extension' contenteditable="true"><?= $user['extension']; ?> </span>
    </div>
    <div>
      <strong>принят:</strong>
      <span>
          <?
          $date = date('Y-m-d', strtotime($user['hired']));
          $date_format = $date != '1970-01-01' ? $date : NULL;
          ?>
        <input type = 'date' id="hired" min="2016-08-14" max="2020-08-20" value = "<?= $date_format; ?>" >
      </span>
    </div>
    <div>
      <strong>уволен:</strong>
      <span>
          <? $date_format = date('Y-m-d', strtotime($user['fired'])) != '1970-01-01' ? date('Y-m-d', strtotime($user['fired'])) : NULL; ?>
        <input type = 'date' id="fired" min="2016-08-14" max="2020-08-20" value = "<?= $date_format ?>" >
      </span>
    </div>
    <div>
      <strong>д.р.:</strong>
      <span>
          <? $date_format = date('Y-m-d', strtotime($user['birthDate'])) != '1970-01-01' ? date('Y-m-d', strtotime($user['birthDate'])) : NULL; ?>
        <input type = 'date' id="bday" min="2016-08-14" max="2020-08-20" value = "<?= $date_format ?>" >
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
             ?> </strong>
         <input class ="right" data-id ='<?=$right['id']?>' type="checkbox" <?= in_array($right['id'], $user['rights']) ? 'checked' : '' ?>>
       </div>
<? endforeach; ?>







    <div class="separator btns">
      <button class = "btnadd-user">Создать нового</button>
      <button class = "btnupdate-user save">Сохранить</button>
    </div>
  </div>



</div>
