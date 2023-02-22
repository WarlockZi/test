<?

use \app\Repository\ImageRepository;

?>

<div
	<?= $this->oneOrMany; ?>
	<?= $this->relation; ?>
	<?= $this->slug; ?>
	<?= $this->class; ?>
>
	<?= $this->content;?>


	<? foreach ($this->items as $item): ?>
	  <div class="wrap">
		  <div class="item">
					<?
					$path = "/{$item->imagePath}/{$item->path}/{$item->hash}.{$item->type}";
					$src = ImageRepository::getImg($path);
					?>
			  <img class="" src="<?= $src ?>" alt="">
		  </div>
			 <?= $this->getDetach($item); ?>

	  </div>
	<? endforeach; ?>

</div>

