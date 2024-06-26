<?php

namespace app\controller;


use app\core\Auth;
use app\core\Icon;
use app\Domain\UseCase\CategoryUseCase;
use app\model\Category;
use app\model\Product;
use app\Repository\BreadcrumbsRepository;
use app\Repository\CategoryRepository;


class CategoryController extends AppController
{
   protected $model = Category::class;
   protected CategoryUseCase $case;

   protected CategoryRepository $repo;

   public function __construct()
   {
      parent::__construct();
      $this->repo = new CategoryRepository();
   }

   public function actionIndex(): void
   {
      if ($this->route->slug) {
         $this->route->setView('category');

         $slug     = $this->route->slug;
         $category = $this->repo->indexInstore($slug);

         if ($category) {
//				$category->products->filters = ProductRepository::getFilters();
            $admin       = Auth::isAdmin();
            $edit        = Icon::edit();
            $breadcrumbs = BreadcrumbsRepository::getCategoryBreadcrumbs($category->id, false, false);
            $this->set(compact('admin', 'edit', 'breadcrumbs', 'category'));
            $this->assets->setItemMeta($category);
         } else {

            http_response_code(404);
         }

      } else {
         $this->route->setView('categories');

         $categories = CategoryRepository::indexNoSlug();

         $this->set(compact('categories'));
         $this->assets->setMeta('Категории', 'Категории:VITEX', 'Категории: перчатки медицинские, инструмент для стаматолога, одноразовая одежда, одноразовый инструмент');
      }
   }
}
