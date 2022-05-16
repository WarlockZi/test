<? if (!$item['isTest']): ?>

<li class='has-children level<?= $lev; ?>'>

	<label>
		<span class="arrow"></span>
	  <?= $item['name']; ?>
	</label>

	<?= $this->lable_after($item); ?>

	<? else: ?>

	<?$isTest = $item['isTest'] === '1' ? 'data-istest' : ''; ?>
<li>
	<a data-id=<?= $item['id'] ?>
	   class='level<?= $lev; ?>'
	   href='<?= $this->link; ?><?= $item['id']; ?>'
		 <?= $isTest; ?>
	   title=<?= $item['name']; ?>>

		 <?= $item['name']; ?></a>
	<?= $this->lable_after($item); ?>

	<? endif; ?>
