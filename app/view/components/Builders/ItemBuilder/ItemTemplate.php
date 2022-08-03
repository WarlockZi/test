<div class="item_wrap"
		 data-model="<?= $this->model; ?>"
		 data-id="<?= $this->item['id']; ?>"
>
		 <? if ($this->tabs){
		 	include ROOT . '/app/view/components/Builders/ItemBuilder/withTabs.php';
		 }else{
		 	include ROOT . '/app/view/components/Builders/ItemBuilder/noTabs.php';
		 } ?>
</div>
