<? use \app\Repository\ImageRepository;?>

<div class="detail_images">
	<div class="add_detail_image  ants">
		<div class="text" data-tooltip="Перетащить картику">
			Перетащите картинку в квадрат
		</div>
	</div>
	<div class="images">


		 <? foreach ($this->many as $img): ?>
		  <div class="image">
					<?
					$path = "/{$img->imagePath}/{$img->path}/{$img->hash}.{$img->type}";
					$src = ImageRepository::getImg($path);
					?>
			  <img class="" src="<?= $src ?>" alt="">
			  <div class="detach" data-id="<?= $img->id ?? '' ?>" data-tag="delDetailImage">x</div>
		  </div>
		 <? endforeach; ?>
	</div>
</div>

