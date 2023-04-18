<div class="wrap-admin">

  <div class="pic row">
      <? if (in_array('3', $user['rights'])): // admin ?>
         <? foreach ($pics as $key => $value): ?>
          <div class="column">
              <div >
                <img src="/pic/<?= $value['nameHash'] ?>" alt="">
              </div>
            <span><?= $value['nameRu'] ?> </span>
          </div>
       <? endforeach; ?>
    <? endif; ?>
  </div>




</div>