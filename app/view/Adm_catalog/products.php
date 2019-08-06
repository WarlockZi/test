<div class="adm-submenu">

    <div class="navi">
      <?
      $i = 1;
      while ($i < $cnt_pages):
         ?>
       <a href="?page=<?= $i ?><?= $QSA ? '&' . $QSA : '' ?>"><? echo $i;
      $i++; ?></a>
<? endwhile; ?>
  </div>
  
  </div>
  <div class="adm-content">
  <div class="breadcrumbs-adm">
    <a href  = "/adminsc/index">Admin</a>
    <a href  = "/adminsc/catalog">Каталог</a>
    <div>Товары</div>
  </div>



  <div class="filter">
    <div class="column">
      <label for="name">Название
        <input type="text" name = 'name' value = '<?= !empty($_GET['name']) ? $_GET['name'] : ''; ?>'>
      </label>
      <label for="name">Активный
        <input type="checkbox" name = 'aсt' <?= (isset($_GET['act']) && $_GET['act'] == 1) ? 'checked' : '' ?>>
      </label>
      <label for="name">Артикул
        <input type="text" name = 'art' value = '<?= !empty($_GET['art']) ? $_GET['art'] : ''; ?>'>
      </label>
    </div>
    <button class = 'btn-filter'>Найти</button>
  </div>

  <div class="column">


    <table cellspacing="0" cellpadding="4" >

      <thead>
        <tr>
          <th>ID</th>
          <th>Название</th>
          <th>Акт.</th>
          <th>Артикул</th>
          <th class = "thumb">Картинка</th>

          <th class="save">Удал.</th>
          <th class = 'edit'>Измен.</th>
        </tr>
      </thead>
      <tbody>
          <?
          $i = 1;
          foreach ($products as $product):
             ?>
           <tr class = <?= $product['id'] ?>>
             <td><?= $product['id'] ?></td>
             <td class="name" contenteditable="true">
   <?= $product['name'] ?>
             </td>
             <td>
               <input type = 'checkbox'  class="act" <?= $product['act'] == 'Y' ? 'checked' : '' ?>>
             </td>
             <td class="art"><?= $product['art'] ?>
             </td>
             <td>
               <img class = "thum" src = "/pic<?= ($product['preview_pic'] && is_file(ROOT . PROJ . "/pic" . $product['preview_pic']) ) ? $product['preview_pic'] : '/srvc/nophoto-min.jpg' ?>">
             </td>


             <td>
               <a class="save" data-id = <?= $product['id'] ?>>Удал.</a>
             </td>
             <td>
               <a href = "/adminsc/product/edit/<?= $product['id'] ?>" class="edit" >Измен.</a>
             </td>

           </tr>

<? endforeach; ?>
      </tbody>
    </table>
    <br>
    <br>
    <button class = "btnadd-user">Создать нового</button>


  </div>

</div>