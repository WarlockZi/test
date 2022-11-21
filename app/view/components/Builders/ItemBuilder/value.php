<div class="value">

  <? if ($field->html): ?>

    <?= $field->html; ?>

  <? else: ?>

		<div class="<?= $field->type; ?> <?= $field->typeModificator; ?>"
      <?= $this->dataModel; ?>
      <?= $field->datafield; ?>
      <?= $field->contenteditable; ?>
      <?= $field->required; ?>
		>
		  <?= $field->value; ?>

		</div>


  <? endif; ?>
</div>