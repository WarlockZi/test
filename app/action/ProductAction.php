<?php

namespace app\action;

use app\model\Category;
use app\model\Product;
use app\service\Breadcrumbs\NewBread;
use app\service\Meta\MetaService;
use app\service\ShippableUnits\ShippableUnitsService;
use Exception;


class ProductAction
{
    public function __construct(
        private MetaService       $meta,
        private readonly NewBread $breadcrumbs,
    )
    {}

    /**
     * @throws Exception
     */
    public function getBreadcrumbs(Category $category, bool $lastItemIsLink = false): NewBread
    {
        if (!$category) throw new Exception('Breadcrumbs service has no category');
        return $this->breadcrumbs->getParents($category, $lastItemIsLink);
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
    }

}