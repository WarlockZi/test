<?

use \app\view\Accordion\AccordionView;
use \app\view\Test\TestView;
use \app\view\Question\QuestionView;

?>
<div class="adm-content">

	<div class="test-edit-wrapper">

		 <? TestView::testHead(); ?>

		<div class="test-edit__cont">

				<?= AccordionView::testEditAccordion() ?>

				<?= QuestionView::getEditContent($test)?>

		</div>
	</div>


</div>
