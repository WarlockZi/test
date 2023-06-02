<?php


namespace app\Repository;


use app\controller\Controller;
use app\controller\FS;
use app\model\Product;
use app\model\Unit;
use app\model\Val;
use app\view\components\Builders\Morph\MorphBuilder;
use app\view\Image\ImageView;

class ProductRepository extends Controller
{
	public static $ProductRepository;
	protected $viewPath;

	public function __construct()
	{
		$this->viewPath = \app\core\FS::platformSlashes(ROOT.'/app/view/Product/');
	}

	public static function edit(int $val)
	{
		return Product::query()
//			->orderBy('sort')
			->with('category.properties.vals')
			->with('category.parentRecursive')
			->with('category.parents')
			->with('mainImages')
			->with('values')
			->with('manufacturer.country')
			->with('detailImages')
			->with('smallpackImages')
			->with('bigpackImages')

			->with(['baseUnit'=>function ($query)use($val){
				$query->with(['units'=>function($query)use($val){
						$query->wherePivot('product_id',$val);
					}]
					)
				;
			}])

			->find($val);
	}

	public static function main(string $slug)
	{
		return Product::query()
			->orderBy('sort')
			->with('category.properties.vals')
			->with('category.parentRecursive')
			->with('category.parents')
			->with('price')
			->with('mainImages')
			->with('values')
			->with('manufacturer.country')
			->with('detailImages')
			->with('smallpackImages')
			->with('bigpackImages')
			->with('baseUnit')
			->where('slug', $slug)
			->first();
	}

	public static function list()
	{
		return Product::query()
			->with('price')
			->take(20)
			->orderBy('sort')
			->get();
	}

	public static function preparePropertiesList(Product $product)
	{
		$arr = [
			['name' => 'Артикул', 'value' => $product->art],
			['name' => 'Страна', 'value' => $product->manufacturer->country->name ?? 'Неизвестен'],
			['name' => 'Производитель', 'value' => $product->manufacturer->name ?? 'Неизвестен'],
		];

		foreach ($product->values as $value) {
			$property = Val::find($value->id)->property->name;
			array_push($arr, ['name' => $property, 'value' => $value->name]);
		}
		return $arr;
	}

	public static function clear()
	{
		$deleted = FS::delFilesFromPath("\pic\product\\");
		ImageRepository::delAll();
	}

	public static function priceStatic($column, $item, $d)
	{
		return $item->getRelation('price')->price??0;
	}

	public static function imageStatic($column, $item, $d)
	{
		$art = trim($item->art);
		$src = "/pic/product/uploads/{$art}.jpg";
		if (is_file(ROOT . $src)) {
			return "<img style='width: 50px; height: 50px;' src='{$src}'>";
		} else {
			return ImageView::noImage();
		}
	}

	public static function getCard($slug)
	{
		$product = self::edit('slug', $slug);
		return $product;
	}

	public static function getFilters()
	{
		$self = new static();
		$filters= [
			'instore'=>'Показать с остатком = 0',
			'price'=>'Показать c ценой = 0',
		];


		return \app\core\FS::getFileContent($self->viewPath.'filters.php',compact('filters'));
	}

}