
<div class="videoinstructions">

	<div class="page-name">Видео инструкции</div>
	<div class="column">
		 <? $tag = ''; ?>

		 <? foreach ($videos as $video): ?>
			 <? if ($tag !== $video['tag']): ?>
			  <h1>
						 <?= $video['tag']; $tag = $video['tag'];?>
			  </h1>
			 <? endif; ?>
		  <a href="<?= $video['link']; ?>">
					<?= \app\core\Icon::youtube(); ?>
					<?= $video['name']; ?>
		  </a>
		 <? endforeach; ?>

	</div>

</div>
