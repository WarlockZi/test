<? ob_start();
?>

<div class="big_pack_images">
	<div class="add_big_pack_image  ants">
		<div class="text" data-tooltip="Перетащить картику">
			Перетащите картинку в квадрат
		</div>
	</div>
	<div class="images">

		<? foreach ($product->bigPackImages as $img): ?>
			<div class="image">
				<?
				$ext = \app\Repository\ImageRepository::getExt($img->type);
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
