<?

use \app\view\Accordion\AccordionView;
use \app\view\Test\TestView;
use \app\view\Question\QuestionView;

?>


	<div class="test-edit-wrapper">

		 <? TestView::testHead(); ?>

		<div class="test-edit__cont">

				<?= AccordionView::testEditAccordion() ;
						$test = QuestionView::getEditContent($test);
						if ($test):
				?>
							<?= $test;?>


				<?else:?>
							<div class=''>Выберите тест для редактирования</div>
				<?endif;?>

		</div>
	</div>



