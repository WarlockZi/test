<?php

namespace app\view\Product;

use app\model\Category;
use app\model\Manufacturer;
use app\model\Product;
use app\model\Unit;

use app\view\components\Builders\Builder;
use app\view\components\Builders\Dnd\DndBuilder;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;

use app\view\components\Builders\Morph\MorphBuilder;
use app\view\components\Builders\SelectBuilder\ListSelectBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductView
{

	public $model = 'product';

	protected static function clean(string $str){
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

	public static function getCardDetailImage($image)
	{
		$im = "<img class = 'detail-image' src='{$image->getFullPath($image)}' alt=''></img>";
		return "<div class='detail-image-wrap'>{$im}</div>";
	}

	public static function getCardImages(string $title,
																			 Collection $collection,
																			 string $class='detail-images-wrap')
	{
		ob_start();
		$detail_image = '';
		foreach ($collection as $image) {
			$detail_image .= self::getCardDetailImage($image);
		}
		include ROOT . '/app/view/Product/detail_images.php';
		return ob_get_clean();
	}

	public static function edit(Model $product): string
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
					->html(self::getCategorySelect($product))
					->contenteditable()

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
				ItemFieldBuilder::build('baseUnit', $product)
					->name('Базовая ед')
					->html(self::getBaseUnit($product))
					->get()
			)
			->field(
				ItemFieldBuilder::build('mainUnit', $product)
					->name('Основная ед')
					->html(self::getMainUnit($product))
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
						self::getMainImage($product)
					)
					->get()
			)
			->tab(
				ItemTabBuilder::build('Детальные картинки')
					->html(
						self::getDetailImages($product)
					)
					->get()
			)
			->tab(
				ItemTabBuilder::build('Внутритарная упаковка')
					->html(
						self::getSmallPackImages($product)
					)
					->get()
			)
			->tab(
				ItemTabBuilder::build('Транспортная упаковка')
					->html(
						self::getBigPackImages($product)
					)
					->get()
			)
			->del()
			->save()
			->toList('list')
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


	protected static function getSmallPackImages(Product $product): string
	{
		return MorphBuilder::build(
			$product,
			'Image',
			'smallpack',
			'dnd',
			)
//			->many($product->smallpackImages)
			->content(
				DndBuilder::build('product', 'dnd')
					->get()
			)
			->detach('detach')
			->get();
	}

	protected static function getBigPackImages($product): string
	{
		return MorphBuilder::build(
			$product,
			'Image',
			'bigpack',
			'mainImages',
			)
			->detach('detach')
			->content(
				DndBuilder::build('product', 'dnd')
					->get()
			)
//			->template('many.php')
//			->many($product->bigpackImages)
//			->dnd(
//				'many_dnd_plus.php',
//				'holder',
//				'dnd',
//				'Перетащите файл сюда',
//				Icon::plus(),
//				'catalog',
//				)
			->get();
	}

	protected static function getDetailImages($product): string
	{
		return MorphBuilder::build(
			$product,
			'Image',
			'detail',
			'dnd',
			)
//			->many($product->detailImages)
			->content(
				DndBuilder::build('product', 'dnd')
					->get()
			)
			->detach('detach')

			->get();
	}

	protected static function getMainImage($product): string
	{
		return MorphBuilder::build(
			$product,
			'Image',
			'main',
			'mainImages',
			)
			->detach('detach')
			->class('dnd')
			->content(
				DndBuilder::build('product')
					->get()
			)
			->get();
	}

	protected static function getMainUnit(Model $product): string
	{
		$f = SelectBuilder::build()
			->array(Unit::forSelect()->toArray())
			->field('main_unit')
			->initialOption('', 0)
			->selected($product->main_unit)
			->get();
		return $f;
//		return include ROOT . '/app/view/Product/main_unit.php';
	}

	protected static function getBaseUnit(Model $product): string
	{
		$f = SelectBuilder::build()
			->array(Unit::forSelect()->toArray())
			->field('base_unit')
			->initialOption('', 0)
			->selected($product->base_unit)
			->get();
		return self::clean($f);
	}
	protected static function getCategorySelect(Model $product): string
	{
		$f = SelectBuilder::build()
			->tree(Category::all(),'children')
			->field('category_id')
			->initialOption('', 0)
			->selected($product->category_id??0)
			->get();
		return self::clean($f);
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

}
