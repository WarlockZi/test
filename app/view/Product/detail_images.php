<? ob_start();
?>

<div class="detail_images">
	<div class="add_detail_image  ants">
		<div class="text" data-tooltip="Перетащить картику">
			Перетащите картинку в квадрат
		</div>
	</div>
	<div class="images">


		 <? foreach ($product->detailImages as $img): ?>
		  <div class="image">
					<?
					$ext = \app\Repository\ImageRepository::getFileExt($img->type);
					$path = "/pic/product/{$img->hash}.{$ext}";
					$src = \app\Repository\ImageRepository::getImg($path);
					?>
			  <img class="" src="<?= $src ?>" alt="">
			  <div class="del" data-id="<?=$img->id??''?>" data-tag="delDetailImage">x</div>
		  </div>
		 <? endforeach; ?>
	</div>
</div>

<? return ob_get_clean(); ?>
