<?php

namespace app\controller;


use app\core\Auth;
use app\core\Icon;
use app\Repository\BreadcrumbsRepository;
use app\Repository\CategoryRepository;
use app\view\share\card_panel\CardPanel;


class CategoryController extends AppController
{
    protected CardPanel $categoryView;
    protected CategoryRepository $repo;

    public function __construct()
    {
        parent::__construct();
        $this->repo         = new CategoryRepository();
        $this->categoryView = new CardPanel();
    }

    public function actionIndex(): void
    {
        if ($this->route->slug) {
            $this->route->setView('category');

            $slug     = $this->route->slug;
            $category = $this->repo->indexInstore($slug);

            if ($category) {
                $admin       = Auth::isAdmin();
                $edit        = Icon::edit();
                $breadcrumbs = BreadcrumbsRepository::getCategoryBreadcrumbs($category->id, false, false);
                $this->set(compact('admin', 'edit', 'breadcrumbs', 'category'));
                $title    = $category->ownProperties->seo_title ?? $category->name;
                $desc     = $category->ownProperties->seo_description ?? $category->name;
                $keywords = $category->ownProperties->seo_keywords ?? $category->name;
                $this->assets->setMeta($title, $desc, $keywords);
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
