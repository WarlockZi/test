<? use \app\Repository\ImageRepository;
use \app\controller\FS;?>

<div class="detail_images">
	<div class="add_detail_image" data-tooltip="Перетащить картику">
<!--		<div class="text" >-->
			<? include FS::getAbsoluteFilePath(ICONS,'plus.svg')?>
<!--		</div>-->
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

