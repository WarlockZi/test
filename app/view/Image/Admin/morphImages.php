<?

use app\Repository\ImageRepository;

$path = "/{$item->imagePath}/{$item->path}/{$item->hash}.{$item->type}";
$src = ImageRepository::getImg($path);

?>

<div class="wrap">
	<div class="item">

		<img class="" src="<?= $src ?>" alt="">
	</div>
	<?= self::getDetach($item); ?>

</div>
