<?php

namespace app\controller\Admin;

use app\Actions\ProductAction;
use app\controller\AppController;
use app\core\Response;
use app\Repository\BreadcrumbsRepository;
use app\Repository\ProductFilterRepository;
use app\Repository\ProductRepository;
use app\view\Product\ProductArrayFormView;


class ProductController extends AppController
{
   private ProductRepository $repo;

   public function __construct()
   {
      parent::__construct();
      $this->repo = new ProductRepository();
   }

   public function actionEdit(): void
   {
      $id   = $this->route->id;
      $prod = $this->repo->edit($id);
//		$p = $prod->toArray();

      if ($prod) {
         $product     = ProductArrayFormView::edit($prod);
         $breadcrumbs = BreadcrumbsRepository::getProductBreadcrumbs($prod, true, true);
         $this->set(compact('product', 'breadcrumbs'));
      }
      $this->assets->setProduct();
      $this->assets->setQuill();
   }

   public function actionList(): void
   {
      $items = ProductRepository::list();
      $list  = ProductArrayFormView::list($items, 'Товары');
      $this->set(compact('list'));
   }

   public function actionTrashed(): void
   {
      $items   = $this->repo->trashed();
      $trashed = ProductArrayFormView::list($items, 'Удаленные товары');
      $this->set(compact('trashed'));
   }

   public function actionFilter(): void
   {
      $res = ProductFilterRepository::make($_POST)->get();
      Response::exitJson($res);
   }

   public function actionChangeval()
   {
      $this->repo->changeVal($this->ajax);
   }

   public function actionDeleteunit(): void
   {
      $this->repo->deleteUnit($this->ajax);
   }

   public function actionChangeunit()
   {
      $this->repo->changeUnit($this->ajax);
   }

   public function actionAttachmainimage()
   {
      if (!$_FILES['file']) Response::exitWithPopup('Ошибка - не передан файл');
      $productId = $_POST['productId'];
      if (!$productId) Response::exitWithPopup('Ошибка - нет id продукта');
      $srcs = ProductAction::attachMainImage($_FILES['file'], $productId);
      if ($srcs) Response::exitJson([$srcs]);
   }

   public function actionChangepromotion()
   {
      ProductAction::changePromotion($this->ajax);
   }

   public function actionSetbaseequalmainunit()
   {
      if (ProductAction::setBaseEqualMainUnit($this->ajax)) {
         Response('Обновлено');
      }
      Response->exitJson(['popup' => 'ошибка']);
   }
}

