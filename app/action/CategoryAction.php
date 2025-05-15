<?php

namespace app\action;

use app\model\Category;
use app\service\Breadcrumbs\NewBread;
use app\service\Cache\Cache;
use app\service\Category\CategoryService;
use app\service\MetaService\MetaService;
use app\service\Router\SlugService;
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
        $bs = new NewBread($category, $lastItemIsLink);
        return $bs->getParents();

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

    public function setCategoryMeta($category): void
    {
        $this->meta->setCategoryMeta($category);
    }
    public function setCategoriesMeta(): void
    {
        $this->meta->setCategoriesMeta();
    }

}