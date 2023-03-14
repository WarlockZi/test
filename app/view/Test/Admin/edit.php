<?

use app\view\Accordion\AccordionView;
use app\view\Test\TestView;

?>
	<div class="test-edit-wrapper">

		 <? TestView::testHead(); ?>

		<div class="test-edit__cont">

				<?= AccordionView::testEdit() ?>

			<div class="extra-wrap">

					 <?= $item??"Выберите тест для редактирования"; ?>
			</div>

		</div>

	</div>



