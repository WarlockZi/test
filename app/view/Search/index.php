<main>

  <div class="search-wrap">
    <p>Страница поиска</p>
    <? foreach ($result as $item): ?>
       <div class="string">
         <div class="search-img">
           <img src="pic<?= $item['pic'] ?>" alt="">
         </div>
         <p><?= $item['value'] ?></p>
       </div>
    <? endforeach ?>
  </div>
</main>


