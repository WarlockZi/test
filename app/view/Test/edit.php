<?

use \app\view\Accordion\AccordionView;

?>
<div class="adm-content">


	<div class="test-edit-wrapper">

		 <? include ROOT . '/app/view/Test/test_head.php'; ?>

		<div class="test-edit__cont">

			<div class='accordion_wrap'>
					 <?= AccordionView::testEditAccordion() ?>
				<!--					 --><? // include ROOT . '/app/view/Test/edit_accordion.php' ?>

					 <? include ROOT . '/app/view/Test/edit_add-test-button.php' ?>
			</div>

			<div class="test-edit__content">

					 <?= $item ?? ''; ?>

			</div>
		</div>

	</div>

</div>
