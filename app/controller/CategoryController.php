<?php

namespace app\controller;

use app\core\Auth;
use app\model\Order;
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
            $this->view = 'category';
            $slug       = $this->route->slug;

            $category = $this->repo->indexInstore($slug);

            if ($category) {
                $user     = Auth::getUser();
                if ($user) {
                    $orders = Order::where('user_id', $user->id)->get();
                } else {
                    $orders = Order::where('sess', session_id())->get();
                }

                $breadcrumbs = BreadcrumbsRepository::getCategoryBreadcrumbs($category->id, false, false);
                $this->setVars(compact('breadcrumbs', 'category','orders'));

                $title    = $category->seo_title();
                $desc     = $category->seo_description();
                $keywords = $category->ownProperties->seo_keywords ?? $category->name;
                $this->assets->setMeta($title, $desc, $keywords);
            } else {
                $rootCategories = CategoryRepository::frontCategories();
                $this->setVars(compact('rootCategories'));
                http_response_code(404);
            }

        } else {
            $this->view = 'categories';

            $categories = CategoryRepository::frontCategories();

            $this->setVars(compact('categories'));
            $this->assets->setMeta('Категории', 'Категории:VITEX', 'Категории: перчатки медицинские, инструмент для стаматолога, одноразовая одежда, одноразовый инструмент');
        }
    }
}
