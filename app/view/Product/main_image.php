<?php

use app\Repository\ImageRepository;

?>
	<figure class="zoom" style="background-image: url('<?= $product->mainImagePath; ?>')">
		 <?= ImageRepository::getProductMainImage($product); ?>
	</figure>


