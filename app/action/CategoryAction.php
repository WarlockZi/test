<?php

namespace app\action;

use app\model\Category;
use app\service\Breadcrumbs\NewBread;
use app\service\Cache\Redis\Cache;
use app\service\Category\CategoryService;
use app\service\Meta\CategoryMetaService;
use app\service\ShippableUnits\ShippableUnitsService;
use app\service\Slug\SlugService;
use Exception;


class CategoryAction
{
    public function __construct(
        private readonly CategoryMetaService $meta,
        private readonly SlugService         $slug,
        private readonly CategoryService     $category,
        private readonly NewBread            $breadcrumbs,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function getBreadcrumbs(Category $category, bool $lastItemIsLink): NewBread
    {
        if (!$category) throw new Exception('Breadcrumbs service has no category');
        return $this->breadcrumbs->getParents($category, $lastItemIsLink);
    }

    public function similarCategories(string $slug): array
    {
        $slugLastSegment = $this->slug::categoryLastSegment($slug);
        return Cache::remember('similarCategories_' . $slugLastSegment,
            function () use ($slugLastSegment) {
                $subslugs = $this->slug::getSubslugs($slugLastSegment, 4);

                return $this->category::similarCategories($subslugs)->toArray();
            },
            Cache::$timeLife1_000
        );
    }

    public function setCategoryMeta(Category $category): CategoryMetaService
    {
        return $this->meta->setMeta(
            $category->seo_title(),
            $category->seo_description(),
            $category->seo_keywords(),
        );
    }

    public function setCategoriesMeta(): CategoryMetaService
    {
        return $this->meta->setMeta(
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