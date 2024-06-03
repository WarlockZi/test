<?

use \app\view\Accordion\AccordionView;
use \app\view\Test\TestView;
use \app\view\Question\QuestionView;

?>


	<div class="test-edit-wrapper">

		 <? include ROOT . '/app/view/Test/test_head.php'; ?>

		<div class="test-edit__cont">

				<?= AccordionView::testEdit() ;
						$test = QuestionView::getEditContent($test);
						if ($test):
				?>
							<?= $test;?>


				<?else:?>
							<div class=''>Выберите тест для редактирования</div>
				<?endif;?>

		</div>
	</div>



