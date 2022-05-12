<?foreach ($tests as $t):?>
<?$selected = $t['id']===$test['id']?'selected':''?>

	<option data-question-parent-id="<?=$t['id'];?> <?=$selected;?>">
		<?=$t['name'];?>
	</option>
<?endforeach;?>
