<?php

namespace app\action;

use app\model\Category;
use app\service\Cache\Redis\Cache;
use app\service\Category\CategoryService;
use app\service\Meta\CategoryMetaService;
use app\service\ShippableUnits\ShippableUnitsService;
use app\service\Slug\SlugService;


class CategoryAction
{
    public function __construct(
        private readonly CategoryMetaService $meta,
        private readonly SlugService         $slug,
        private readonly CategoryService     $category,
    )
    {
    }

    public function similarCategories(string $slug): array
    {
        return $this->similarCategorySegments($slug);
//        return $this->similarCategoryLastSegment($slug);

    }

    private function similarCategorySegments(string $slug)
    {
        $slugSegments = $this->slug::categorySlugSegments($slug);
        return Cache::remember('similarCategories_segments' . $slug,
            function () use ($slugSegments) {
                $cats = [];
                foreach ($slugSegments as $slugSegment) {
                    $c = Category::whereHas('ownProperties',
                        function ($query) use ($slugSegment) {
                            $query->where('path','LIKE', "%{$slugSegment}%");
                        })->with('ownProperties')->get();
                    if ($c) {
                        $cats[$slugSegment] = $c->toArray();
                    }
                }
                return $cats??[];
            },
            Cache::$timeLife1_000
        );
    }

    private function similarCategoryLastSegment(string $slug)
    {
        $slugLastSegment = $this->slug::categoryLastSegment($slug);
        return Cache::remember('similarCategories_' . $slugLastSegment,
            function () use ($slugLastSegment) {
                $subslugs = $this->slug::getSubslugs($slugLastSegment, 4);

                return $this->category::similarCategories($subslugs) ?? [];
            },
            Cache::$timeLife1_000
        );
    }
//    public function categoryMeta(Category $category): array
//    {
//        return $this->meta->setMeta(
//            $category->seo_title(),
//            $category->seo_description(),
//            $category->seo_keywords(),
//        );
//    }

    public function setCategoriesMeta(): array
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