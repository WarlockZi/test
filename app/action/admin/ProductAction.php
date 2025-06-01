<?php

namespace app\action\admin;

use app\model\Product;
use app\model\ProductUnit;
use app\service\Breadcrumbs\NewBread;
use app\service\Image\ProductMainImage;
use app\service\Response;
use app\service\Router\IRequest;
use Exception;


class ProductAction
{
    public function __construct(
        protected ProductMainImage $productMainImage
    )
    {

    }

    /**
     * @throws Exception
     */
    public function getBreadcrumbs(array $category, bool $lastItemIsLink): NewBread
    {
        if (!$category) throw new Exception('Breadcrumbs service has no category');
        $bs = new NewBread($lastItemIsLink);
        return $bs->getParents($category);
    }

    public function saveMainImage(array $file, Product $product): string
    {
        $absPath = $this->productMainImage->init($file, $product)->save();
//        $this->productMainImage->reduceQuality();
        return $absPath;
    }

    public static function changeBaseIsShippable(IRequest $req): void
    {
        $pu              = ProductUnit::query()
            ->where('product_1s_id', $req['product_1s_id'])
            ->where('is_base', 1)
            ->where('multiplier', 1)
            ->first();
        $pu->isBase      = 1;
        $pu->isShippable = (int)$req['base_is_shippable'];
        $pu->save();
        response()->json(['popup' => 'ok']);
    }

    public function changeUnit(IRequest $req): void
    {
        $productId   = $req['pivot']['product_id'];
        $unitId      = $req['morphed']['new_id'];
        $productUnit = [
            'unit_id' => $unitId,
            'multiplier' => $req['pivot']['multiplier'],
            'is_shippable' => $req['pivot']['is_shippable'],
        ];

        try {
            $unit = ProductUnit::query()
                ->updateOrCreate(
                    ['product_1s_id' => $productId,
                        'unit_id' => $unitId],
                    $productUnit);
            Response::exitWithPopup('изменено');
        } catch (\Throwable $exception) {
            Response::exitWithPopup('не изменено');
        }
    }

    public function deleteUnit(IRequest $req): void
    {
        try {
            $productId = $req['pivot']['product_id'];
            $unitId    = $req['morphed']['old_id'];
            ProductUnit::where('product_1s_id', $productId)
                ->where('unit_id', $unitId)
                ->delete();
            response()->json(['popup' => 'удален', 'ok' => 'ok']);
        } catch (\Throwable $exception) {
            Response::exitWithPopup('не удален');
        }
    }

    public function changeVal(IRequest $req): void
    {
        $product = Product::find($req['product_id']);
        $newVal  = $req['morphed']['new_id'];
        $oldVal  = $req['morphed']['old_id'];

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

    public function changePromotion(IRequest $request): void
    {

    }


}