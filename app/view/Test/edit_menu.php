<div class='test-edit-menu'>

	<?
	use app\view\widgets\menu\Menu;

	new app\view\widgets\menu\Menu([
		'tpl' => ROOT . "/app/view/widgets/menu/menu_tpl/edit_test_menu.php",
		'cache' => 60,
	]);
	?>

</div>
