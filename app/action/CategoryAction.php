<?php

namespace app\action;

use app\model\Category;
use app\service\Breadcrumbs\NewBread;
use app\service\Cache\Cache;
use app\service\Category\CategoryService;
use app\service\Meta\MetaService;
use app\service\Router\SlugService;
use app\service\ShippableUnits\ShippableUnitsService;
use Exception;


class CategoryAction
{
    public function __construct(
        private MetaService $meta,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function getBreadcrumbs(array $category, bool $lastItemIsLink): NewBread
    {
        if (!$category) throw new Exception('Breadcrumbs service has no category');
        $breadcrumbs = new NewBread($lastItemIsLink);
        return $breadcrumbs->getParents($category);

    }

    public function similarCategories(string $slug): array
    {
        $slugLastSegment = SlugService::categoryLastSegment($slug);
        return Cache::get('similarCategories_' . $slugLastSegment,
            function () use ($slugLastSegment) {
                $subslugs = SlugService::getSubslugs($slugLastSegment, 4);

                return CategoryService::similarCategories($subslugs)->toArray();
            },
            Cache::$timeLife1_000
        );
    }

    public function setCategoryMeta($category): MetaService
    {
        return $this->meta->setMeta(
            $category->seo_title(),
            $category->seo_description(),
            $category->seo_keywords(),
        );
    }

    public function setCategoriesMeta(): void
    {
        $this->meta->setMeta(
            'Категории',
            'Категории:VITEX',
            'Категории: перчатки медицинские, инструмент для стаматолога, одноразовая одежда, одноразовый инструмент',
        );
    }

    public function shippableTable(Category $category): ShippableUnitsService
    {
        return new ShippableUnitsService('category', $category);
    }
}