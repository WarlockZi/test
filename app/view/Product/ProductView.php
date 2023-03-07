<?php

namespace app\view\Product;

use app\model\Manufacturer;
use app\model\Product;
use app\model\Unit;
use app\Repository\CategoryRepository;
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
use app\view\components\Builders\SelectBuilder\TreeOptionsBuilder;
use app\view\components\HasOne\HasOne;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductView
{

	protected $model = 'product';

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
		include ROOT . '/app/view/Product/detail_images.php';
		return ob_get_clean();
	}

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
					->get()
			)
			->tab(
				ItemTabBuilder::build('Описание')
					->html(
						self::getDescription($product)
					)
					->get()
			)
			->tab(
				ItemTabBuilder::build('Seo')
					->html(
						self::getSeo($product)
					)
					->get()
			)
			->tab(
				ItemTabBuilder::build('Основная картинка')
					->html(
						self::getImage($product, 'main', 'mainImages')
					)
					->get()
			)
			->tab(
				ItemTabBuilder::build('Детальные картинки')
					->html(
						self::getImage($product, 'detail', 'detailImages')
					)
					->get()
			)
			->tab(
				ItemTabBuilder::build('Внутритарная упаковка')
					->html(
						self::getImage($product, 'smallpack', 'smallpackImages')
					)
					->get()
			)
			->tab(
				ItemTabBuilder::build('Транспортная упаковка')
					->html(
						self::getImage($product, 'bigpack', 'bigPackImages')
					)
					->get()
			)
			->del()
			->save()
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


	protected static function getImage(Product $product, string $slug, string $relation)
	{
		return MorphBuilder::build(
			$product,
			'Image',
			$slug,
			$relation,
			)
			->detach('detach')
			->class('dnd')
			->html(
				DndBuilder::build('product')
					->get()
			)
			->get();
	}

	protected static function getSelect(Model $category, Product $product): string
	{
		$str = "<div class='category'>{$category->name}</div>";
		foreach ($category->properties as $property) {
			$intersect = $property->vals->intersect($product->values);
			$selected = $intersect->count() ? $intersect[0]->id : 0;
			$propName = "<div class='name'>{$property->name}</div>";
			$select = SelectBuilder::build()
				->collection($property->vals)
				->morph('values', $property->id, 'one', true)
				->selected($selected)
				->initialOption('', 0)
				->get();
			$str .= "<div class='property'>{$propName}<br>{$select}</div>";
		}
		return $str;
	}

	protected static function getProperties(Product $product): string
	{
		$str = "";
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

	public static function renderToCart(Product $product)
	{
		ob_start();
		include ROOT . '/app/view/Product/Main/toCart.php';
		return ob_get_clean();
	}

	public static function renderProperty($property)
	{
		ob_start();
		include ROOT . '/app/view/Product/property.php';
		return ob_get_clean();
	}
//	protected static function getMainImage($product): string
//	{
//		return MorphBuilder::build(
//			$product,
//			'Image',
//			'main',
//			'mainImages',
//			)
//			->detach('detach')
//			->class('dnd')
//			->content(
//				DndBuilder::build('product')
//					->get()
//			)
//			->get();
//	}
//	protected static function getSmallPackImages(Product $product): string
//	{
//		return MorphBuilder::build(
//			$product,
//			'Image',
//			'smallpack',
//			'smallpackImages',
//			)
//			->detach('detach')
//			->content(
//				DndBuilder::build('product', 'dnd')
//					->get()
//			)
//			->get();
//	}
//	protected static function getBigPackImages($product): string
//	{
//		return MorphBuilder::build(
//			$product,
//			'Image',
//			'bigpack',
//			'bigPackImages',
//			)
//			->detach('detach')
//			->content(
//				DndBuilder::build('product', 'dnd')
//					->get()
//			)
//			->get();
//	}
//	protected static function getDetailImages($product): string
//	{
//		return MorphBuilder::build(
//			$product,
//			'Image',
//			'detail',
//			'detailImages',
//			)
//			->detach('detach')
//			->content(
//				DndBuilder::build('product', 'dnd')
//					->get()
//			)
//			->get();
//	}

}
