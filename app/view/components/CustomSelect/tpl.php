<?
$tab=str_repeat($this->tab,$level);
$selected = $item['id']==$this->selected?'selected':'';

?>
<option value="<?= $item['id'] ?>" <?=$selected;?>>
	<?= $tab??'' ?><?= $item['name'] ?>
</option>
<?if(isset($item['childs'])){
	$this->getChilds($item['childs'],$level);
}?>

