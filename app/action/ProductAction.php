<?php

namespace app\action;

use app\model\Product;
use app\service\Breadcrumbs\NewBread;
use app\service\Meta\MetaService;
use app\service\ShippableUnits\ShippableUnitsService;
use Exception;


class ProductAction
{
    public function __construct(
        private readonly MetaService $meta,
    )
    {}

    /**
     * @throws Exception
     */
    public function getBreadcrumbs(array $category, bool $lastItemIsLink = false): NewBread
    {
        if (!$category) throw new Exception('Breadcrumbs service has no category');
        $breadcrumbs = new NewBread($lastItemIsLink);
        return $breadcrumbs->getParents($category);
    }

    public function shippableUnits(string $module, Product $product): ShippableUnitsService
    {
        return (new ShippableUnitsService($module, $product));
    }
    public function setMeta(Product $product): MetaService
    {
        return $this->meta->setMeta(
            $product->seo_title(),
            $product->seo_description(),
            $product->ownProperties->seo_keywords ?? $product->name
        );
    }
    public function similarProducts(string $slug): array
    {
        return [];
//        $slugLastSegment = SlugService::categoryLastSegment($slug);
//        return Cache::get('similarCategories_' . $slugLastSegment,
//            function () use ($slugLastSegment) {
//                $subslugs = SlugService::getSubslugs($slugLastSegment, 4);
//
//                return CategoryService::similarCategories($subslugs)->toArray();
//            },
//            Cache::$timeLife1_000
//        );
    }
//    public function setProductMeta($category): void
//    {
//        $this->meta->setProductMeta($category);
//    }
//    public function getProductShippableUnits(Product $product): array
//    {
//        $sid = $product['1s_id'];
//        $productArr[$sid]['base_unit_price'] = $product->price;
//        foreach ($product->shippableUnits as $unit) {
//            $unitArr                    = $unit->toArray();
//            $unitArr['base_unit_price'] = $product->price;
//            foreach ($product->orderItems as $orderItem) {
//                if ($orderItem->unit->id === $unit->id) {
//                    $unitArr['count'] = $orderItem->count;
//                }
//            }
//            $productArr[$sid][] = $unitArr;
//        }
//        $orderArr[] = $productArr;
//        return  $orderArr;
//    }
}