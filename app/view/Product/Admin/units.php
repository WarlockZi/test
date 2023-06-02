<?

use app\view\FormViews\UnitFormView;
use app\core\Icon;

?>
<div class="units">

	<div class="column">
		<div class="title">Единицы</div>
		<div class="head">
			<div class="name">Единица</div>
			<div class="multiplier">Коэфф</div>
			<div class="base-unit">Базовая ед.</div>
			<div class="del"><?= Icon::trashIcon() ?></div>
		</div>

		<div class="rows">
			<div class="none">
					 <?= $selector; ?>
			</div>
				<? foreach ($baseUnit->units as $unit): ?>
			  <div class="row">
				  <?= UnitFormView::selector($baseUnit->id, $unit->id)?>
				  <input type="number" value="<?= $unit->pivot->multiplier ?>">
				  <div class="base-unit"><?= $baseUnit->name ?></div>
				  <div class="del">X</div>
			  </div>
				<? endforeach; ?>
		</div>

		<div class="add-unit"
		     data-unit="<?= $baseUnit->id ?>"
		>+
		</div>

	</div>
</div>
