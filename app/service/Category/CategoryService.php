<?php

namespace app\service\Category;

use app\action\CategoryAction;
use app\repository\CategoryRepository;
use app\service\Cache\Redis\Cache;
use Illuminate\Support\Str;

class CategoryService
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private CategoryAction $categoryAction,
    )
    {
    }
    public function similarCategories(string $slug): void
    {
        $similarCategories = $this->categoryAction->similarCategorySegments($slug);
        $meta              = $this->categoryAction->setMeta();

        view('category.notFound',
            compact( 'similarCategories', 'meta'),
            404);
    }

    public function index(string $slug): object|array|string|null
    {
        $category = Cache::remember('category_'.Str::slug($slug), function ()use ($slug) {
            return $this->categoryRepository->indexInstore($slug);
        }, 20);
        return $category;
    }

    public function notFound()
    {
        $categories = APP->get('rootCategories');
        $meta       = $this->categoryAction->setCategoriesMeta();
        view('category.categories', compact('meta', 'categories'));

    }
}