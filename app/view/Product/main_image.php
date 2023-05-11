<?php

use app\Repository\ImageRepository;

?>
<div class="main-image">
	<figure class="zoom" style="background-image: url('<?= ImageRepository::getProductMainImageSrc($product); ?>')">
		 <?= ImageRepository::getProductMainImage($product); ?>
	</figure>
</div>
