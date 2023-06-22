<?php

use app\Repository\ImageRepository;

?>
	<figure class="zoom" style="background-image: url('<?= ImageRepository::getProductMainImageSrc($product); ?>')">
		 <?= ImageRepository::getProductMainImage($product); ?>
	</figure>
