<section>

	<div class="container-edit-test">

		<div class='test-menu-wrap'>
			<div class='add-test'>Добавить тест</div>

			<?
			new app\view\widgets\menu\Menu([
				'tpl' => ROOT . "/app/view/widgets/menu/menu_tpl/edit_test_menu.php",
				'cache' => 60,
			]);
			?>

		</div>

		<div class="content">
			<p class="test-name" value="<?= $_SESSION['testId'] ?>"><?= $_SESSION['test_name'] ?></p>
			<?= $pagination ?>

			<div class="blocks">
				<? foreach ($testDataToEdit as $q_id => $block): ?>
					<? require ROOT . '/app/view/Test/editBlockQuestion.php' ?>
				<? endforeach; ?>

			</div>
		</div>

		<?= $this::getJs() ?>
</section>