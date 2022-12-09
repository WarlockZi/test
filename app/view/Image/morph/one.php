<?

use \app\Repository\ImageRepository;

?>


<div class="morph" data-type="image">

	<div class="items">

		 <?= $this->addAction; ?>

		 <? foreach ($this->many as $item): ?>
		  <div class="wrap">
			  <div class="item">
						 <?
						 $path = "/{$item->imagePath}/{$item->path}/{$item->hash}.{$item->type}";
						 $src = ImageRepository::getImg($path);
						 ?>
				  <img class="" src="<?= $src ?>" alt="">
			  </div>

		 <?= $this->detachAction; ?>


		  </div>
		 <? endforeach; ?>
	</div>

</div>

