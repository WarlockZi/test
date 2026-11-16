<?php

namespace app\service\Category;

use app\action\CategoryAction;
use app\blade\Blade;
use app\repository\CategoryRepository;
use app\service\Cache\Redis\Cache;
use Illuminate\Support\Str;
use Throwable;

class CategoryService
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private CategoryAction     $categoryAction,
    )
    {
    }

    public function similarCategories(string $slug): void
    {
        set_error_handler(function ($severity, $message, $file, $line) {
            if (!(error_reporting() & $severity)) {
                return false;
            }
            throw new \ErrorException($message, 0, $severity, $file, $line);
        });

        $similarCategories = $this->categoryAction->similarCategorySegments($slug);
        $meta              = $this->categoryAction->setMeta();

        try {
            $blade = APP->get(Blade::class);
            $view  = $blade->run('category.notFound', compact('similarCategories', 'meta'));
            response($view, 404);
        } catch (Throwable $exception) {
            view("exceptions.error", compact('exception'),404);
        }finally {
            // Гарантированно восстанавливаем обработчик, даже если catch не сработал
            restore_error_handler();
        }
    }

    public function index(string $slug): object|array|string|null
    {
        $category = Cache::remember('category_' . Str::slug($slug), function () use ($slug) {
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