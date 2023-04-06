<div class='location'>
	<?= \app\core\Icon::mapPin('feather');?>
	 <?$adress =\app\controller\Address::getFactAddress();?>
	 <?= $adress ?>
</div>
