<div class="test-edit-wrapper">

	<div class='test-edit-menu'>

		<?
		new app\view\widgets\menu\Menu([
			'tpl' => ROOT . "/app/view/widgets/menu/menu_tpl/edit_test_menu.php",
			'cache' => 60,
		]);
		?>

		<div class='test-edit-menu__add-bttn' href="/adminsc/test/show">Добавить
			<div class="test-edit-menu__add-bttn-wrap">

				<div class="test-edit-menu__add-bttn-test">Добавить тест</div>
				<div class="test-edit-menu__add-bttn-path">Добавить папку</div>
			</div>
		</div>
	</div>

	<? include ROOT . '/app/view/Test/edit_content.php' ?>
</div>
