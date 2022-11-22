<div class='location'>
	<? include ICONS . '/feather/map-pin.svg';?>
	 <?$adress =\app\controller\Address::getFactAddress();?>
	 <?= $adress ?>
</div>
