<div class="test-edit-wrapper">

	<div class='test-edit-menu'>

		<?
		new app\view\widgets\menu\Menu([
			'tpl' => ROOT . "/app/view/widgets/menu/menu_tpl/edit_test_menu.php",
			'cache' => 60,
		]);
		?>

		<a class='add-test' href="/adminsc/test/show">Добавить тест</a>
	</div>

	<? include ROOT . '/app/view/Test/edit_content.php' ?>
</div>
