<div class="custom-catalog-item__wrapper" data-model="<?= $this->modelName ?>">
		 <? if ($this->tabs){
		 	include ROOT . '/app/view/components/CustomCatalogItem/withTabs.php';
		 }else{
		 	include ROOT . '/app/view/components/CustomCatalogItem/noTabs.php';
		 } ?>
</div>
