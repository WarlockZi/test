<?
use \app\view\Accordion\AccordionView;
?>
<div class="adm-content">

	<section class="test-do">

		 <? include ROOT . '/app/view/Test/test_head.php'; ?>

		<div class="content">
			<?=AccordionView::testDo();?>
<!--				--><?// include ROOT . '/app/view/Test/test_do_accordion.php'; ?>

				<? include ROOT . '/app/view/Test/do_content.php'; ?>

	</section>
</div>
