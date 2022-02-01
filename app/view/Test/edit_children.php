<? if (isset($path_children)): ?>
	<div class="list">
		<? foreach ($path_children as $child): ?>
			<div class="path-child__row">
				<?= include ROOT . '/app/view/components/icons/path.php' ?>
				<div><?= $child['test_name'] ?></div>
			</div>
		<? endforeach; ?>
	</div>
<?else:?>
В данной папке нет тестов
<? endif; ?>