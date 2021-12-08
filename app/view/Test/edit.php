<div class="test-edit-wrapper">

	<div class='test-edit__accordion'>
		<!--	--><? // include ROOT . '/app/view/Test/edit_menu.php' ?>
		<? include ROOT . '/app/view/Test/edit_accordion.php' ?>

		<div class='test-edit-menu__add-bttn' href="/adminsc/test/show">Добавить
			<div class="test-edit-menu__add-bttn-wrap">
				<a href="/adminsc/test/show" class="test-edit-menu__add-bttn-test">Добавить тест</a>
				<a href="/adminsc/test/pathshow" class="test-edit-menu__add-bttn-path">Добавить папку</a>
			</div>
		</div>

	</div>


	<? include ROOT . '/app/view/Test/edit_content.php' ?>
</div>
