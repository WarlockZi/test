<?

use app\view\FormViews\UnitFormView;
use app\core\Icon;

?>
<div class="units">

	<div class="column">
		<div class="title">Единицы</div>
		<div class="row">
			<div class="name">Единица</div>
			<div class="multiplier">Коэфф</div>
			<div class="baseUnit">Базовая ед.</div>
			<div class="del"><?= Icon::trashIcon() ?></div>
		</div>


		 <? foreach ($units as $unit): ?>
		  <div class="row">
			  <div class="name"><?= $selector() ?></div>
			  <div class="multiplier"><?=$unit->multiplier?></div>
			  <div class="baseUnit"><?= $baseUnit->name ?>"</div>
			  <div class="del"><?= Icon::trashIcon() ?></div>
		  </div>
		 <? endforeach; ?>

		<div class="add-unit"
		     data-unit="<?= $baseUnit->id ?>"
		>+
		</div>

	</div>
</div>
