<? ob_start();
?>

<div class="small_pack_images">
	<div class="add_small_pack_images  ants">
		<div class="text" data-tooltip="Перетащить картику">
			Перетащите картинку в квадрат
		</div>
	</div>
	<div class="images">


		<? foreach ($product->smallPackImages as $img): ?>
			<div class="image">
				<?
				$ext = \app\Repository\ImageRepository::getFileExt($img->type);
				$path = "/pic/product/{$img->hash}.{$ext}";
				$src = \app\Repository\ImageRepository::getImg($path);
				?>
				<img class="" src="<?= $src ?>" alt="">
				<div class="del" data-id="<?=$img->id??''?>" data-tag="delSmallPackImage">x</div>
			</div>
		<? endforeach; ?>
	</div>
</div>

<? return ob_get_clean(); ?>
