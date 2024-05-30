<?php

namespace app\controller\Admin;

use app\Actions\ProductAction;
use app\Actions\ProductFilterAction;
use app\controller\AppController;
use app\core\Response;
use app\Repository\BreadcrumbsRepository;
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

    public function actionEdit()
    {
        $id   = $this->route->id;
        $prod = ProductRepository::edit($id);
//		$p = $prod->toArray();

        if ($prod) {
            $product     = ProductArrayFormView::edit($prod);
            $breadcrumbs = BreadcrumbsRepository::getProductBreadcrumbs($prod, true, true);
        }
        $this->set(compact('product', 'breadcrumbs'));
        $this->assets->setProduct();
        $this->assets->setQuill();
    }

    public function actionList()
    {
        $items = ProductRepository::list();
        $list  = ProductArrayFormView::list($items, 'Товары');
        $this->set(compact('list'));
    }

    public function actionTrashed()
    {
        $items   = ProductRepository::trashed();
        $trashed = ProductArrayFormView::list($items, 'Удаленные товары');
        $this->set(compact('trashed'));
    }

    public function actionFilter()
    {
        $res = ProductFilterAction::make($_POST)->get();
        Response->exitJson($res);
    }

    public function actionChangeval()
    {
        ProductAction::changeVal($this->ajax);
    }
   public function actionDeleteunit()
   {
      $this->repo->deleteUnit($this->ajax);
   }
    public function actionChangeunit()
    {
        ProductAction::changeUnit($this->ajax);
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

