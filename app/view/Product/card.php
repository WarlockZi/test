<main class="card">

	<? if ($card): ?>

	  <br>
	  <div>Товар - <span><?= $card['name'] ?></span></div>
	  <br>
	  <div>Артикул - <span><?= $card['art'] ?></span></div>
	  <br>
	  <div>Описание - <span><?= $card['dtxt'] ?></span></div>

	<? else: ?>

	  <div>Такого нет</div>

	<? endif; ?>
</main>
