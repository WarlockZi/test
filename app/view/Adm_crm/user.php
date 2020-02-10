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

  <div class="wrap-admin">
    <div class="work-area">
      <input id = 'token' type="hidden" value="<?= $_SESSION['token'] ?>">
      <div class="tabs">
        <input id="tab1" type="radio" name="tabs" checked>
        <label for="tab1" title="Подробно">Основное</label>
        <input id="tab2" type="radio" name="tabs">
        <label for="tab2" title="Права">Права</label>
        <input id="tab3" type="radio" name="tabs">
        <label for="tab3" title="Сео">Сео</label>
        <input id="tab4" type="radio" name="tabs">
        <label for="tab4" title="Картинки">Еще</label>



        <section id="content-tab1" class="column">

          <div class = 'admin-flex-table column'>
            <div class = 'row'>
              <strong>id :</strong>
              <span id = 'id' <?= $user['id'] ?: ''; ?>><?= $user['id'] ?: ''; ?></span>
            </div>
            <div class = 'row'>
              <strong>Наименование :</strong>
              <span contenteditable id = 'name'><?= $user['name'] ?: ''; ?></span>
            </div>

            <div class = 'row'>
              <strong>подтвержден :</strong>
              <select name="conf" id="conf" value = 1>
                <option value="0" <?= $user['confirm'] == '0' ? 'selected' : ''; ?>>0</option>
                <option value="1" <?= $user['confirm'] == '1' ? 'selected' : ''; ?>>1</option>
              </select>
            </div>
            <div class = 'row'>
              <strong>email :</strong><span id ='email' contenteditable="true"><?= $user['email']; ?></span>
            </div>
            <div class = 'row'>
              <strong>фамилия :</strong><span id ='s-name' contenteditable="true"><?= $user['surName']; ?> </span>
            </div>
            <div class = 'row'>
              <strong>имя :</strong><span id ='name' contenteditable="true"><?= $user['name']; ?> </span>
            </div>
            <div class = 'row'>
              <strong>отчетсво:</strong><span id ='m-name' contenteditable="true"><?= $user['middleName']; ?> </span>
            </div>
            <div class = 'row'>
              <strong>phone:</strong><span id ='phone' contenteditable="true"><?= $user['phone']; ?> </span>
            </div>
            <div class = 'row'>
              <strong>добавочный:</strong><span id ='extension' contenteditable="true"><?= $user['extension']; ?> </span>
            </div>
            <div class = 'row'>
              <strong>принят:</strong>
              <span>
                  <?
                  $date = date('Y-m-d', strtotime($user['hired']));
                  $date_format = $date != '1970-01-01' ? $date : NULL;
                  ?>
                <input type = 'date' id="hired" min="2016-08-14" max="2020-08-20" value = "<?= $date_format; ?>" >
              </span>
            </div>
            <div class = 'row'>
              <strong>уволен:</strong>
              <span>
                  <? $date_format = date('Y-m-d', strtotime($user['fired'])) != '1970-01-01' ? date('Y-m-d', strtotime($user['fired'])) : NULL; ?>
                <input type = 'date' id="fired" min="2016-08-14" max="2020-08-20" value = "<?= $date_format ?>" >
              </span>
            </div>
            <div class = 'row'>
              <strong>д.р.:</strong>
              <span>
                  <? $date_format = date('Y-m-d', strtotime($user['birthDate'])) != '1970-01-01' ? date('Y-m-d', strtotime($user['birthDate'])) : NULL; ?>
                <input type = 'date' id="bday" min="2016-08-14" max="2020-08-20" value = "<?= $date_format ?>" >
              </span>
            </div>
            <div class = 'row'>
              <strong></strong>
            </div>
          </div>




        </section>

        <section id="content-tab2">

          <div class = 'admin-flex-table column'>
              <? foreach ($rights as $right): ?>
               <div class="row">
                 <strong><?=
                     $right['name'];?>
                      </strong>
                 <input class ="right" data-id ='<?= $right['id'] ?>' type="checkbox" <?= in_array($right['id'], $user['rights']) ? 'checked' : '' ?>>
               </div>
            <? endforeach; ?>
          </div>

          <section id="content-tab3">
          </section>

          <section id="content-tab4">
          </section>


      </div>
      <div class="separator btns">
        <button id="user-update-btn">Сохранить
        </button>
        <button id="user-create-btn">Добавить пользователя
        </button>
      </div>
    </div>

  </div>





</div>
