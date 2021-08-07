<div class="test-edit-wrapper">

	<div class='test-edit-menu'>
		<a class='add-test' href="/adminsc/test/show">Добавить тест</a>

		<?
		new app\view\widgets\menu\Menu([
			'tpl' => ROOT . "/app/view/widgets/menu/menu_tpl/edit_test_menu.php",
			'cache' => 60,
		]);
		?>
		<div class="test-edit__view-toggle">
			<div class="with-pagination"></div>
			<div class="without-pagination"></div>
		</div>

	</div>

	<? include ROOT . '/app/view/Test/edit_content.php' ?>
	<? include ROOT . '/app/view/Test/edit_content2.php' ?>
</div>
