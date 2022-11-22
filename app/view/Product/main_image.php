<? ob_start();

?>

<div class="image_main">

	<div class="add_main_image  ants">
		<div class="text" data-tooltip="Перетащить картику">
			Перетащите картинку в квадрат
		</div>
	</div>

	<div class="images">
		<div class="image">
			<img src="<?= $src ?? ''; ?>" alt="" data-tooltip="Перетащить картику">
			<div class="del" data-id="<?=$img->id??''?>" data-tag="delMainImage">x</div>
		</div>

	</div>


</div>

<? return ob_get_clean(); ?>
