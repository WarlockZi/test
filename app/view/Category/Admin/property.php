<?
ob_start();

use app\core\Icon;
use \app\view\Property\PropertyFormView;

$excluded = PropertyFormView::usedPropsArr($category)
?>
<div class="properties">

	<div class="column">
		<div class="title">Свойства</div>

		<div class="head">
			<div class="name">Свойство</div>

			<div class="del"><?= Icon::trashIcon() ?></div>
			<div class="edit"><?= Icon::edit() ?></div>
		</div>

		<div class="rows">
			<div class="none">
					 <?= PropertyFormView::newPropertySelector($excluded); ?>
			</div>
				<? foreach ($category->properties as $property): ?>
			  <div class="row">
				  <?= PropertyFormView::selector($excluded, $property->id)?>
				  <div class="del">X</div>
				  <div class="edit"><?=Icon::edit()?></div>
			  </div>
				<? endforeach; ?>
		</div>

		<div class="add-unit"
		     data-unit="<?= $category->id ?>"
		>+
		</div>

	</div>
</div>
<?return ob_get_clean();?>