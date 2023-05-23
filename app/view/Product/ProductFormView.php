<?php


namespace app\view\Product;


use app\core\FS;
use app\model\Category;
use app\model\Manufacturer;
use app\model\Product;
use app\model\Unit;
use app\Repository\CategoryRepository;
use app\Repository\ProductRepository;
use app\view\components\Builders\Builder;
use app\view\components\Builders\Dnd\DndBuilder;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;
use app\view\components\Builders\Morph\MorphBuilder;
use app\view\components\Builders\SelectBuilder\ArrayOptionsBuilder;
use app\view\components\Builders\SelectBuilder\ListSelectBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\Image\ImageView;
use app\view\Property\PropertyView;
use Illuminate\Database\Eloquent\Collection;

class ProductFormView
{

	public static function edit(Product $product): string
	{
		return ItemBuilder::build($product, 'product')
			->pageTitle('Товар :  ' . $product['name'])
			->field(
				ItemFieldBuilder::build('id', $product)
					->name('ID')
					->get()
			)
			->field(
				ItemFieldBuilder::build('slug', $product)
					->name('Адрес')
					->html(
						"<a href='/product/{$product->slug}'>{$product->slug}</a>"
					)
					->get()
			)
			->field(
				ItemFieldBuilder::build('sort', $product)
					->name('Порядок')
					->contenteditable()
					->get()
			)
			->field(
				ItemFieldBuilder::build('art', $product)
					->name('Артикул')
					->contenteditable()
					->required()
					->get()
			)
			->field(
				ItemFieldBuilder::build('category_id', $product)
					->name('Категория')
					->html(CategoryRepository::selector($product->category_id))
					->get()
			)
			->field(
				ItemFieldBuilder::build('name', $product)
					->name('Наименование')
					->contenteditable()
					->required()
					->get()
			)
			->field(
				ItemFieldBuilder::build('base_unit', $product)
					->name('Базовая единица')
					->html(self::getUnit($product->baseUnit->id ?? 0, 'base_unit'))
					->get()
			)
			->field(
				ItemFieldBuilder::build('mainUnit', $product)
					->name('Основная ед')
					->html(self::getUnit($product->mainUnit->id ?? 0, 'main_unit'))
					->get()
			)
			->field(
				ItemFieldBuilder::build('manufacturer', $product)
					->name('Производитель')
					->html(
						ListSelectBuilder::build()
							->collection(Manufacturer::all())
							->item($product)
							->field('manufacturer_id')
							->initialOption('', 0)
							->selected($product->manufacturer->id ?? 0)
							->get()
					)
					->get()
			)
			->tab(
				ItemTabBuilder::build('Свойства товара')
					->html(
						self::getProperties($product)
					)
			)
			->tab(
				ItemTabBuilder::build('Описание')
					->html(
						self::getDescription($product)
					)
			)
			->tab(
				ItemTabBuilder::build('Seo')
					->html(
						self::getSeo($product)
					)
			)
			->tab(
				ItemTabBuilder::build('Основная картинка')
					->html(
						ProductView::mainImage($product)
					)
			)
			->tab(
				ItemTabBuilder::build('Детальные картинки')
					->html(
						self::getImage($product, 'detailImages', 'detail', true)
					)
			)
			->tab(
				ItemTabBuilder::build('Внутритарная упаковка')
					->html(
						self::getImage($product, 'smallpackImages', 'smallpack', true)
					)
			)
			->tab(
				ItemTabBuilder::build('Транспортная упаковка', true)
					->html(
						self::getImage($product, 'bigPackImages', 'bigpack', true)
					)
			)
			->del()
			->toList('list')
			->get();
	}


	protected static function getUnit(int $selected, string $field)
	{
		return self::clean(
			SelectBuilder::build(
				ArrayOptionsBuilder::build(Unit::forSelect())
					->selected($selected)
					->get()
			)
				->field($field)
				->initialOption('', 0)
				->get()
		);
	}


	protected static function getImage(Product $product,
																		 string $relation,
																		 string $slug,
																		 bool $many = false)
	{
		$imgs = ImageView::morphImages($product, $relation);

		$img = MorphBuilder::build($product,
			$relation,
			$slug,
			$many
		)
//			->class('dnd-image')
			->detach('detach')
			->html(
				DndBuilder::make('product') . $imgs
			)
			->get();

		return $img;
	}

	protected static function getSelect(Category $category, Product $product): string
	{
		$str = "<div class='category'>{$category->name}</div>";
		foreach ($category->properties as $property) {
			$str .= PropertyView::getProductSelector($property, $product);
		}
		return $str;
	}


	protected static function getProperties(Product $product, string $str = ''): string
	{
		$currentCategory = $product->category;

		while ($currentCategory) {
			$str .= self::getSelect($currentCategory, $product);
			$currentCategory = $currentCategory->parentRecursive;
		}
		return $str;
	}

	protected static function getSeo($product): string
	{
		return "<div class='show'>" .
			ItemFieldBuilder::build('description', $product)
				->name('Description')
				->contenteditable()
				->get()->toHtml('product') .
			ItemFieldBuilder::build('title', $product)
				->name('Title')
				->contenteditable()
				->get()->toHtml('product') .
			ItemFieldBuilder::build('keywords', $product)
				->name('Key words')
				->contenteditable()
				->get()->toHtml('product') .
			"</div>";
	}

	protected static function getDescription($product): string
	{
		return include ROOT . '/app/view/Product/description.php';
	}

	public static function list(Collection $items): string
	{
		return MyList::build(Product::class)
			->pageTitle('Товары')
			->column(
				ListColumnBuilder::build('id')
					->name('ID')
					->get()
			)
			->column(
				ListColumnBuilder::build('name')
					->name('Наименование')
					->contenteditable()
					->search()
					->width('1fr')
					->get()
			)
			->column(
				ListColumnBuilder::build('art')
					->name('Артикул')
					->contenteditable()
					->search()
					->width('100px')
					->get()
			)
			->column(
				ListColumnBuilder::build('sort')
					->name('Порядок')
					->contenteditable()
					->search()
					->width('50px')
					->get()
			)
			->column(
				ListColumnBuilder::build('price')
					->name('Цена')
					->contenteditable()
					->width('70px')
					->function(ProductRepository::class, 'priceStatic')
					->get()
			)
//			->column(
//				ListColumnBuilder::build('image')
//					->name('Картинка')
//					->width('100px')
//					->function(ProductRepository::class, 'imageStatic')
//					->get()
//			)
			->items($items)
			->edit()
			->del()
			->addButton('ajax')
			->get();
	}

	public static function belongToCategory($category)
	{
		$arr = $category->toArray();
		$str = '';
		foreach ($arr['products'] as $product) {
			$str .= "<div>{$product['name']}</div>";
		}
		return $str;
	}

	protected static function clean(string $str)
	{
		$builder = new Builder();
		return $builder->clean($str);
	}


	public static function renderProperty($property)
	{
		return FS::getFileContent(ROOT . '/app/view/Product/property.php', compact('property'));
	}

	public static function getCardDetailImage($image)
	{
		$im = "<img class = 'detail-image' src='{$image->getFullPath($image)}' alt=''></img>";
		return "<div class='detail-image-wrap'>{$im}</div>";
	}

	public static function getCardImages(string $title,
																			 Collection $collection,
																			 string $class = 'detail-images-wrap')
	{
		ob_start();
		$detail_image = '';
		foreach ($collection as $image) {
			$detail_image .= self::getCardDetailImage($image);
		}
		include ROOT . '/app/view/Product/card/detail_images.php';
		return ob_get_clean();
	}



}