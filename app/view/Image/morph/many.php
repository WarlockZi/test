<?

use \app\Repository\ImageRepository;

?>


<div class="morph" data-type="<?= $this->morph; ?>" <?= $this->slug; ?>>

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
					<? include $this->detach; ?>

		  </div>
		 <? endforeach; ?>
	</div>

</div>

