<div class="adm-content">

	<div class="opentest-edit-wrapper">

		 <? include ROOT . '/app/view/OpenTest/test_head.php'; ?>

		<div class="test-edit__cont">

			<div class='accordion_wrap'>
				<?=\app\view\Accordion\AccordionView::opentestEdit()?>
<!--					 --><?// include ROOT . '/app/view/OpenTest/edit_accordion.php' ?>
					 <? include ROOT . '/app/view/OpenTest/edit_add-test-button.php' ?>
			</div>

				<? if (isset($test)): ?>
					<? include ROOT . '/app/view/OpenTest/edit_content.php' ?>
				<? else: ?>
			  <h3>Нет теста</h3>
				<? endif; ?>

		</div>
	</div>
</div>
