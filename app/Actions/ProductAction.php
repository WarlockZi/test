<?php


namespace app\Actions;

use app\Domain\Product\Image\ProductMainImage;
use app\model\Product;
use Exception;

class ProductAction
{

	public static function attachMainImage(array $file, string $productId): string
	{
		//Уменьшать размер и качество картинки автоматом
		//Заменить слеш в названии на дефис

		ProductMainImage::class;
		if ($file['size'] > 300000) {
			throw new Exception('file size is big --- !!!');
		}
		$product = Product::query()->find($productId);
		$mainImage = new ProductMainImage($product, $file);

		$mainImage->deletePreviousFile();
		$mainImage->save();
		return $mainImage->getRelativePath();
	}

	public static function setBaseEqualMainUnit($req)
	{
		$product = Product::where('1s_id', $req['1s_id'])->first();
		try {
			$product->properties()
				->updateOrCreate(
					['product_1s_id' => $req['1s_id']],
					['base_equals_main_unit' => $req['equal']]);
			return true;
		} catch (Exception $e) {
			return false;
		}
	}

/*	protected static function getFilePaths($file, $storage)
	{
		$rel = FS::platformSlashes($storage->getImagePath() . $file['name']);
		$abs = $storage->relativePath . $storage->productImagesPath . $file['name'];
		$srcs['absoluteSrcs'][] = $abs;
		$srcs['relativeSrcs'][] = $rel;
		return $srcs;
	}*/

	public static function changeVal(array $req)
	{
		$product = Product::find($req['product_id']);
		$newVal = $req['morphed']['new_id'];
		$oldVal = $req['morphed']['old_id'];

		if (!$oldVal) {
			$product->values()->attach($newVal);
			exit(json_encode(['popup' => 'Добавлен']));

		} else if (!$newVal) {
			$product->values()->detach($oldVal);
			exit(json_encode(['popup' => 'Удален']));

		} else {
			if ($newVal === $oldVal) exit(json_encode(['popup' => 'Одинаковые значения']));
			$product->values()->detach($oldVal);
			$product->values()->attach($newVal);
			exit(json_encode(['popup' => 'Поменян']));
		}
	}

	public static function changeUnit(array $req)
	{
		UnitAction::changeUnit($req);
	}

	public static function changePromotion(array $req)
	{
		UnitAction::changeUnit($req);
	}
}