<div class="custom-catalog-item__wrapper"
		 data-model="<?= $this->modelName ?>"
		 data-table="<?= $this->tableClassName ?>"
		 data-id="<?= $this->item['id'] ?>"
>
		 <? if ($this->tabs){
		 	include ROOT . '/app/view/components/CustomCatalogItem/withTabs.php';
		 }else{
		 	include ROOT . '/app/view/components/CustomCatalogItem/noTabs.php';
		 } ?>
</div>
