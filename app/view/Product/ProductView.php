<?php

namespace app\view\Product;

use app\model\Illuminate\Product as IlluminateProduct;
use app\model\Illuminate\Propertable;
use app\model\Image;
use app\model\Product;
use app\Repository\ImageRepository;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use Illuminate\Database\Eloquent\Model;

class ProductView
{

	public $illuminateModel = IlluminateProduct::class;
	public $modelName = Product::class;
	public $model = 'product';

	public static function edit(Model $product): string
	{

		$p = $product->toArray();

		return ItemBuilder::build($product, 'product')
			->pageTitle('Товар :  ' . $product['name'])
			->field(
				ItemFieldBuilder::build('id', $product)
					->name('ID')
					->get()
			)
			->field(
				ItemFieldBuilder::build('name', $product)
					->name('Наименование')
					->contenteditable()
					->required()
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
				ItemTabBuilder::build('Основная картинка')
					->html(
						self::getMainImage($product)
					)
					->get()
			)
			->tab(
				ItemTabBuilder::build('Подробные картинки')
					->html(
						self::getDetailImages($product)
					)
					->get()
			)
			->del()
			->save()
			->toList()
			->get();
	}

	protected static function getSelectedProperties($product)
	{
		return Propertable::where(
			['propertable_type' => \app\model\Illuminate\Product::class,
				'propertable_id' => $product->id]
		)
			->select('val_id', 'property_id')
			->get()
			->keyBy('property_id')
			->map(function ($v, $k) {
				return $v->val_id;
			})
			->toArray();
	}

	protected static function getProperties($product): string
	{
		$str = "";
		$recProps = self::getProperyRecursiveProps($product);
		$productVals = self::getSelectedProperties($product);

		foreach ($recProps as $category) {
			$str .= "<div class='category'>{$category['category']}</div><br>";
			foreach ($category['properties'] as $property) {
				$selected = array_key_exists($property['id'], $productVals)
					? $productVals[$property['id']]
					: 0;
				$str .= "<div class='property'><div class='name'>{$property['name']}</div><br>";
				$vals = self::prepareVals($property['vals']);
				$str .= SelectBuilder::build()
					->array($vals)
					->model('property')
					->modelId($property['id'])
					->selected($selected)
					->initialOption('', 0)
					->get();
				$str .= "</div>";
			}
		}
		return $str;
	}

	protected static function getDetailImages($product): string
	{
		$str = include ROOT . '/app/view/Product/detail_images.php';
		return $str;
	}

	protected static function getMainImage($product): string
	{
		$src = ImageRepository::getImg();
		$img = $product->mainImage;
		if ($img) {
			$hash = $img->hash;
			$ext = ImageRepository::getExt($img->type);
			$src = ImageRepository::getImg("\pic\product\\{$hash}.{$ext}") ?? '';
		}
		$str = include ROOT . '/app/view/Product/main_image.php';
		return $str;
	}

	protected static function prepareVals($vals)
	{
		$arr = [];
		foreach ($vals as $val) {
			$arr[$val['id']] = $val['name'];
		}
		return $arr;
	}

	protected static function hasCat($category)
	{
		return $category['category_recursive'];
	}

	protected static function getProperyRecursiveProps($product)
	{
		$parents = $product->category;
		$arr[$parents['id']]['category'] = $parents->name;
		$arr[$parents['id']]['properties'] = $parents->properties->toArray();
		$arr[$parents->category_recursive['id']]['category'] = $parents->category_recursive->name;
		$arr[$parents->category_recursive['id']]['properties'] = $parents->category_recursive->properties->toArray();
		while (self::hasCat($parents->category_recursive)) {
			$parents = $parents->category_recursive;
			$arr[$parents->category_recursive->id]['category'] = $parents->category_recursive->name;
			$arr[$parents->category_recursive->id]['properties'] = $parents->category_recursive->properties->toArray();
		}
		return $arr;
	}


	public static function listAll(): string
	{
		$view = new self;
		return MyList::build($view->modelName)
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
			->all()
			->edit()
			->del()
			->addButton('ajax')
			->get();
	}

	public static function card($slug)
	{
		$product = IlluminateProduct::
		with('properties', 'category', 'category.category_recursive')
			->where('slug', '=', $slug)
			->get()
			->toArray()[0];
		$product['nav'] = self::getNavigationStr($product['category']['category_recursive']);
		return $product;
	}

	protected static function getNavigationStr(array $arr, $str = '')
	{
		$str = '/' . $arr['alias'];
		while ($arr['category_recursive']) {
			$str .= "/" . $arr['category_recursive'];
			self::getNavigationStr($arr['category_recursive'], $str);
		}
		return $str;
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
