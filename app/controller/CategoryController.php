<?php

namespace app\controller;

use app\Repository\CategoryRepository;
use app\Services\Breadcrumbs\BreadcrumbsService;
use app\view\share\card_panel\CardPanel;

class CategoryController extends AppController
{

    public function __construct(
        protected CardPanel          $categoryView = new CardPanel(),
        protected CategoryRepository $repo = new CategoryRepository(),
        private BreadcrumbsService   $breadcrumbsService = new BreadcrumbsService(),

    )
    {
        parent::__construct();

    }

    public function actionIndex(): void
    {
        $slug = $this->route->slug;
        if ($slug) {
            $this->view = 'category';
            $category   = $this->repo->indexInstore($slug);

            $rootCategories = CategoryRepository::rootCategories() ?? '';
            if ($category) {
                $breadcrumbs = $this->breadcrumbsService->getCategoryBreadcrumbs($category, false, false);
                $this->setVars(compact('breadcrumbs', 'category', 'rootCategories'));

                $title    = $category->seo_title();
                $desc     = $category->seo_description();
                $keywords = $category->ownProperties->seo_keywords ?? $category->name;
                $this->assets->setMeta($title, $desc, $keywords);
            } else {
                $this->setVars(compact('rootCategories'));
                http_response_code(404);
            }

        } else {
            $this->view = 'categories';

            $categories = CategoryRepository::rootCategories();

            $this->setVars(compact('categories'));
            $this->assets->setMeta('Категории', 'Категории:VITEX', 'Категории: перчатки медицинские, инструмент для стаматолога, одноразовая одежда, одноразовый инструмент');
        }
    }
}
