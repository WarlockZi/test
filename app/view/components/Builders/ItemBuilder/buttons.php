<!--  BUTTONS  -->
<div class="item_buttons">

    <?php use app\core\Icon;

	 if ($this->del): ?>
	  <div class="del"
	       data-model="<?= $this->model; ?>"
	       data-id="<?= $this->item['id']; ?>"
	  >
			 <?= Icon::trashIcon() ?>
	  </div>

     <?php endif; ?>

    <?php if ($this->softDel): ?>
	  <div soft-del>
			 <?= Icon::trashIcon() ?>
	  </div>
    <?php endif; ?>


    <?php if ($this->save): ?>
	  <div class="save"
	       data-model="<?= $this->model; ?>"
	       data-id="<?= $this->item['id']; ?>">
			 <?= Icon::save();?>
	  </div>
    <?php endif; ?>

    <?php if ($this->toList): ?>
	  <a href="<?=$this->toListHref; ?>"
	     class="to-list">
			 <?= $this->toListText ?>
	  </a>
    <?php endif; ?>

</div>