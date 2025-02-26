<?$tab=str_repeat($this->tab,$level)?>
<option value="<?= $item['id'] ?>">
	<?= $tab??'' ?><?= $item['name'] ?>
</option>
<?if(isset($item['childs'])){
	$this->getChilds($item['childs'],$level);
}?>

