<tr class = "<?= $uId ?>">
  <td><?= $uId ?></td>
  <td>
    <input type = 'text' class="s-name" value = "">
  </td>
  <td>
    <input type = 'text' class="name" value = "">
  </td>
  <td>
    <input type = 'text' class="m-name" value = "">
  </td>
  <td>
    <input type = 'text' class="phone" value = "">
  </td>
  <td>

    <input type = 'date' class="hired" min="2016-08-14" max="2020-08-20" value = "" >
  </td>
  <td>

    <input type = 'date' class="fired" min="2016-08-14" max="2020-08-20" value = "" >
  </td>
  <td>
    <input type = 'date' class="bday" min="2016-08-14" max="2020-08-20" value = "" >
  </td>
  <?
  $t = 0;
  foreach ($rightTypes as $type):
     ?>
     <td>
       <span><?= $t+1 ?></span>
       <input type="checkbox" class="right <?= $uId; ?>">
     </td>
     <? $t++;
  endforeach;
  ?>
  <td>

    <input type = 'text' class="email" value = "">
  </td>

  <td>
    <input type = 'text' class="confirm" size="1" value = "0">
  </td>

  <td>
    <button class="delete">X</button>      
  </td>
  <td>
    <button class="save new">save</button>  
  </td>

</tr>

