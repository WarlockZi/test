<? foreach ($categories as $category): ?>
	<div class='h-cat'><?= $category['name']; ?>
		<ul>
				<? if (isset($category->childrenNotDeleted)): ?>
					<? foreach ($category->childrenNotDeleted as $item): ?>
				  <li>
					  <a href="/category/<?= $item['slug'] ?>"><?= $item['name'] ?></a>
				  </li>
					<? endforeach; ?>
				<? endif; ?>
		</ul>

	</div>
<? endforeach; ?>
