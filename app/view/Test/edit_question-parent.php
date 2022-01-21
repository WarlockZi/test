<?foreach ($tests as $t):?>
<?$selected = $t['id']===$test['id']?'selected':''?>
	<option  <?=$selected;?> data-question-parent-id="<?=$t['id'];?>"><?=$t['test_name'];?></option>
<?endforeach;?>
