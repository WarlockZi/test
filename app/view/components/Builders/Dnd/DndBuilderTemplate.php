<?= $this->title ?? '' ?>
<div
	<?= $this->morph_model; ?>
	<?= $this->morph_id; ?>

	<?= $this->morph_one_or_many; ?>
	<?= $this->morph_slug; ?>
	<?= $this->class; ?>

	<?= $this->belongsTo_model; ?>
	<?= $this->belongsTo_id; ?>

>

	<div
			data-dnd
		 <?= $this->path; ?>
		 <?= $this->morph_class; ?>
		 <?= $this->tooltip; ?>
	>
		 <?= \app\core\Icon::plus() ?>
	</div>

	<?= \app\Repository\ImageRepository::getMorphOneImage($this->morphed, $this->morphed_relation); ?>


</div>
