<div class="row">
	<div class="property">
						<span>
						<?=$value->property->show_as
						  ?$value->property->show_as
						  :$value->property->name;?>
						</span>
	</div>
	<div class="value"><?= $value->name; ?></div>
</div>