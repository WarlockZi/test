<div class="item_wrap" <?= $this->model; ?> <?= $this->id; ?>>

		 <? if ($this->tabs){
		 	include ROOT . '/app/view/components/Builders/ItemBuilder/withTabs.php';
		 }else{
		 	include ROOT . '/app/view/components/Builders/ItemBuilder/noTabs.php';
		 } ?>
</div>
