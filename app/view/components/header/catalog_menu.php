<div class="header-catalog-menu">
	<? foreach ($list as $mainItem): ?>
		<div class='h-cat'><?= $mainItem['name']; ?>
			<ul>
				<? if (isset($mainItem['childs'])): ?>
					<? foreach ($mainItem['childs'] as $item): ?>
						<li>
							<a href="/<?= $item['alias'] ?>"><?= $item['name'] ?></a>
						</li>
					<? endforeach; ?>
				<? endif; ?>
			</ul>

		</div>
	<? endforeach; ?>


	<div class='h-cat'>Акции
		<ul>
			<li>
				<a href="/rasprodazha">распродажа</a>
			</li>

		</ul>
	</div>

</div>
