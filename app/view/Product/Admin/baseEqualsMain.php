<div class="row">
	<div class="field">
		Базовая единица равна основной
	</div>
	<div class="value">
		 <? if ($vars[0]->properties) {
			 $checked = $vars[0]->properties->base_equals_main_unit ? 'checked' : '';
		 } else {
			 $checked = '';
		 }
		 ?>

		<input data-action="equal" type="checkbox" <?= $checked ?>>

	</div>
</div>
