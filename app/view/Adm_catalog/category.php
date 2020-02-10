<div class="adm-submenu">
	<div class="title">Каталог</div>
	<div class="admin-actions">
		<?

		use \app\core\Base\View;

		new app\view\widgets\menu\Menu([
			'class' => 'admin-category-menu',
			'tpl' => ROOT . "/app/view/widgets/menu/menu_tpl/site_admin_category_menu.php",
			'cache' => 60,
			'sql' => "SELECT * FROM category "
		]);
		$new = $_GET['id'] == 'new';
		$addCategoryButton = "<a href='/adminsc/catalog/category?id=new&parent=`{$_GET['id']}`' 
					   class='btn-add-category'>Добавить категорию</a>";
		?>
	</div>
</div>
<div class="adm-content">
	<div class="breadcrumbs-adm">
		<a href="/adminsc/index">Admin ></a>
		<a href="/adminsc/catalog">Каталог ></a>
		<? if (isset($category['parents'])): ?>
			<? foreach ($category['parents'] as $k => $v): ?>
				<a href="/adminsc/catalog/category?id=<?= $v['id']; ?>"><?= $v['name']; ?></a>
			<? endforeach; ?>
			<div><?= $category['name']; ?></div>
		<? endif; ?>
	</div>

	<div class="wrap-admin">

		<div class="work-area">
			<input id='token' type="hidden" value="<?= $_SESSION['token'] ?>">


			<div class="tabs">
				<input id="tab1" type="radio" name="tabs" checked>
				<label for="tab1" title="Подкатегории">Подробно</label>
				<input id="tab2" type="radio" name="tabs">
				<label for="tab2" title="Свойства">Свойства</label>
				<input id="tab3" type="radio" name="tabs">
				<label for="tab3" title="Сео">Сео</label>
				<input id="tab4" type="radio" name="tabs">
				<?
				if (isset($category['children']['categories']) &&
					$category['children']['categories']) {
					$children = 'Подкатегории';
					$ddProductButton = '';
				} else {
					$children = 'Товары';
					$ddProductButton = '<a href = "product?id=new&category=' . $category['id'] . '" class="add-product">добавить товар</a>';
				}
				?>

				<label for="tab4" title="<?= $children ?>"><?= $children ?></label>
				<? if ((!$new) && ($category)): ?>
					<?=$addCategoryButton?>
				<? endif; ?>

				<section id="content-tab1" class="admin-flex-table">
					<? if ($category): ?>
						<div class="row">
							<strong>id :</strong>
							<span id='id'><?= $category['id'] ?: ''; ?></span>
						</div>
						<div class="row">
							<strong>Наименование :</strong>
							<span contenteditable id='name'><?= $category['name'] ?: ''; ?></span>
						</div>

						<div class="row">
							<strong>Описание :</strong>
							<span contenteditable id='text'
							      class="column"><?= htmlspecialchars($category['text'] ?: ''); ?></span>
						</div>
					<? else: ?>
						<div class="row">
							Такой категории пока что не существует!
							<!--							<span id='id'>--><? //= $category['id'] ?: ''; ?><!--</span>-->
						</div>
					<? endif; ?>

				</section>

				<? ?>
				<section id="content-tab2">
					<? if (isset($category['parents'])): ?>

						<? foreach ($category['parents'] as $parentCat): ?>
							<div class="parent-properties separator">
								Свойства родительской категории
							</div>
							<div class="parent-prop column">
								<? foreach ($parentCat['props'] as $Pprop): ?>
									<div class="category-properties">
										<? foreach ($props as $prop): ?>
											<? if ($Pprop == $prop['id']): ?>
												<?= $prop['name'] ?>
											<? endif; ?>
										<? endforeach; ?>
									</div>
								<? endforeach; ?>
							</div>
						<? endforeach; ?>
					<? endif; ?>

					<div class="properties column">
						<div class="cat-prop">
							Свойства категории
						</div>
						<? if (isset($category['props']) && $category['props']): ?>
							<? foreach ($category['props'] as $catProp): ?>
								<? if ($catProp): ?>
									<select>
										<option value=""></option>
										<? foreach ($props as $prop): ?>
											<? if (!in_array($prop['id'], $thisCatAndParentCatProps)): ?>
												<option
														value="<?= $prop['id']; ?>" <?= $catProp == $prop['id'] ? 'selected' : ''; ?>><?= $prop['name'] ?></option>
											<? else: ?>
												<? if ($prop['id'] == $catProp): ?>
													<option
															value="<?= $prop['id']; ?>" <?= $catProp == $prop['id'] ? 'selected' : ''; ?>><?= $prop['name'] ?></option>
												<? endif; ?>
											<? endif; ?>
										<? endforeach; ?>
									</select>
								<? endif; ?>
							<? endforeach; ?>
						<? endif; ?>
						<select class='new-prop'>

							<option value=""></option>

							<? foreach ($props as $prop): ?>
								<? if (!in_array($prop['id'], $category['parentProps']) && !in_array($prop['id'], $category['props'])): ?>
									<option
											value="<?= $prop['id']; ?>" <?= $catProp == $prop['id'] ? 'selected' : ''; ?>><?= $prop['name'] ?></option>
								<? endif; ?>
							<? endforeach; ?>

						</select>


						<div class="add-property row">

						</div>

					</div>


				</section>

				<section id="content-tab3" class="admin-flex-table">

					<div class="row">
						<strong>title :</strong>
						<span contenteditable id='title'><?= $category['title'] ?: ''; ?></span>
					</div>
					<div class="row">
						<strong>url :</strong>
						<span contenteditable id='alias'><?= $category['alias'] ?: ''; ?></span>
					</div>
					<div class="row">
						<strong>key words :</strong>
						<span contenteditable id='keywords'><?= $category['keywords'] ?: ''; ?></span>
					</div>
					<div class="row">
						<strong>description :</strong>
						<span contenteditable id='description'><?= $category['description'] ?: ''; ?></span>
					</div>
					<div class="row">
						<strong>семантическое ядро :</strong>
						<span contenteditable id='core'><?= $category['core'] ?: ''; ?></span>
					</div>


				</section>

				<section id="content-tab4">


					<? if (isset($category['children']['categories']) && $category['children']['categories']): ?>
						<? foreach ($category['children']['categories'] as $key => $value) : ?>
							<a href="/adminsc/catalog/category?id=<?= $value['id'] ?>"><?= $value['alias'] ?></a>
						<? endforeach; ?>

					<? else: ?>
						<? if (isset($category['parent'])): ?> //чтобы добавить товар категория должна быть сохранена
							<?= $ddProductButton ?>
							<div class="products row">
								<? foreach ($category['children']['products'] as $product) : ?>
									<a class="product w200" href="product?id=<?= $product['id'] ?>">
										<div class="pic w200 h200">
											<img src="<?= $product['dpic'] ? '/pic' . $product['dpic'] : '/pic/srvc/nophoto-min.jpg' ?>"
											     alt="">
										</div>
										<span><?= $product['name'] ?></span>
									</a>

								<? endforeach; ?>
							</div>
						<? endif; ?>
					<? endif; ?>


				</section>
				<div class="separator btns">
					<? if ($category): ?>
						<div class="btn-add-category">Сохранить</div>
					<? endif; ?>
					<? if ((!$new) && ($category)): ?>
						<?=$addCategoryButton?>
					<? endif; ?>
				</div>
			</div>
		</div>

	</div>
</div>