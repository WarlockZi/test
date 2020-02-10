<main class = 'column'>
    <? foreach ($cats_id as $id): ?>
     <a href="/catalog/<?= $id['alias']; ?>">
       <div class="badge">
         <?= $id['id']; ?>
         <?= $id['name']; ?>
       </div>
     </a>
  <? endforeach; ?>
</main>