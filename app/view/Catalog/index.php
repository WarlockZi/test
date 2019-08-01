
<div class="site">
    <? foreach ($cats_id as $id): ?>
     <a href="/catalog/<?= $id['alias']; ?>">
       <div class="badge">
         <?= $id['id']; ?>
         <?= $id['name']; ?>
       </div>
     </a>
  <? endforeach; ?>
</div>