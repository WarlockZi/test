<?php

namespace app\controller;

use app\core\Auth;
use app\Domain\UseCase\ProductUseCase;
use app\Repository\BreadcrumbsRepository;
use app\Repository\OrderRepository;
use app\Repository\ProductRepository;


class ProductController extends AppController
{
//    protected $model;
   protected ProductRepository $repo;

   public function __construct()
   {
      parent::__construct();
      $this->repo = new ProductRepository();
   }

   public function actionIndex(): void
   {
      $slug = $this->route->slug;
      if (!$slug) {
         header('Location:/category');
      }

      $product = $this->repo->main($slug);
      $this->route->setView('product');
      if ($product) {
         $oItems      = OrderRepository::count();
         $breadcrumbs = BreadcrumbsRepository::getCategoryBreadcrumbs($product->category_id, true,);
         $userIsAdmin = Auth::isAdmin();
         $repo        = $this->repo;
         $this->set(compact('repo', 'product', 'breadcrumbs', 'oItems', 'userIsAdmin'));

         $this->assets->setItemMeta($product);
         $this->assets->setProduct();
         $this->assets->setQuill();
      } else {
//         $view = $this->getView();
         $this->assets->setMeta('Страница не найдена');
//         $this->view = $view->get404();
         http_response_code(404);
      }
   }
}
