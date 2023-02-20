<?

use \app\Repository\ImageRepository;

?>

<div <?= $this->oneOrMany; ?>
<!--	--><?//= $this->morphFunction; ?>
	<?= $this->slug; ?>
	<?= $this->class; ?>
	<?= $this->dndPath; ?>
>
	<?= $this->addAction; ?>

	<? if (isset($this->one[0])): ?>
		<? $item = $this->one[0] ?>
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

	<? endif; ?>

</div>

