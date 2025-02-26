<?= $this->pageTitle; ?>
<div class="item-wrap" <?= $this->dataModel; ?> <?= $this->id; ?>>

    <?php if ($this->tabs){
		 	include ROOT . '/app/view/components/Builders/ItemBuilder/withTabs.php';
		 }else{
		 	include ROOT . '/app/view/components/Builders/ItemBuilder/noTabs.php';
		 } ?>
</div>
