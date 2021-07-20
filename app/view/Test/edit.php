<section class = "test-edit-wrapper">

		<div class='test-menu-wrap'>
			<a class='add-test' href="/adminsc/test/show">Добавить тест</a>

			<?
			new app\view\widgets\menu\Menu([
				'tpl' => ROOT . "/app/view/widgets/menu/menu_tpl/edit_test_menu.php",
				'cache' => 60,
			]);
			?>

		</div>

		<div class="content"><div class="row">
			<p class="test-name" value="<?= $test['id'] ?>"><?= $test['test_name']?></p>
				<div class = "test_delete" data-hover = "showTip" data-click = "delete" tip = "удалить тест : <?= $test['test_name']?>">
					<?= require_once ROOT . '/app/view/components/trashIcon.php' ?>
				</div>

			</div>
			<?= $pagination ?>

			<div class="blocks">
				<? foreach ($testDataToEdit as $q_id => $block): ?>
					<? require ROOT . '/app/view/Test/editBlockQuestion.php' ?>
				<? endforeach; ?>
			</div>

</section>