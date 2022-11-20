<div class="value">

  <? if ($field->html): ?>

    <?= $field->html; ?>

  <? else: ?>

		<div class="<?= $field->type; ?>"
      <?= $this->dataModel; ?>
      <?= $field->datafield; ?>
      <?= $field->contenteditable; ?>
      <?= $field->required; ?>
		><?= $this->item[$field->field] ?></div>


  <? endif; ?>
</div>