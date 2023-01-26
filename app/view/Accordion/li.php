<? if (!$item['isTest']): ?>

	<div class="label" >
		<div class="arrow"></div>
		<div class="img"></div>
		 <?= $item['name']; ?>
		 <?= $this->lable_after($item); ?>
	</div>

<? else: ?>

	<a href='<?= $this->link; ?><?= $item['id']; ?>'>
		<span class="img"></span>
		 <?= $item['name']; ?>
	</a>
	<?= $this->lable_after($item); ?>

<? endif; ?>
