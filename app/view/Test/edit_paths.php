<div class="test-update__group">
	<div class="test-path-add__th">Папка</div>
	<select>
		<option value='0'></option>
		<? foreach ($rootTests as $rootTest): ?>
			<option value=<?= $rootTest['id'] ?>
				<?= $rootTest['id'] === $test['parent'] ? 'selected' : ''; ?>>
				<?= $rootTest['name'] ?>
			</option>
		<? endforeach; ?>
	</select>
</div>