<main>

  <div class="search-wrap">
    <p>Страница поиска</p>
    <? foreach ($result as $item): ?>
       <div class="string">
         <div class="search-img">
           <img src="pic<?= $item['preview_pic'] ?>" alt="">
         </div>
         <p><?= $item['name'] ?></p>
       </div>
    <? endforeach ?>
  </div>
</main>


