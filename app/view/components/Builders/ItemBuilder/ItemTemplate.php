<div class="page-title"><?= $this->pageTitle ?></div>
<div class="item_wrap" <?= $this->dataModel; ?> <?= $this->id; ?>>

		 <? if ($this->tabs){
		 	include ROOT . '/app/view/components/Builders/ItemBuilder/withTabs.php';
		 }else{
		 	include ROOT . '/app/view/components/Builders/ItemBuilder/noTabs.php';
		 } ?>
</div>
