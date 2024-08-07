<?php

namespace app\controller\Admin;


use app\controller\AppController;
use app\core\Response;
use app\model\Product;
use app\Repository\BreadcrumbsRepository;
use app\Repository\ProductFilterRepository;
use app\Repository\ProductRepository;
use app\Services\ProductService;
use app\view\Product\Admin\ProductFormView;


class ProductController extends AppController
{
    private ProductRepository $repo;
    private ProductService $service;

    public function __construct()
    {
        parent::__construct();
        $this->repo    = new ProductRepository();
        $this->service = new ProductService();
    }

    public function actionSaveMainImage()
    {
        $file    = $_FILES['file'];
        $product = Product::find($_POST['productId']);
        Response::exitJson([$this->service->saveMainImage($file, $product) ?? 'ошибка сохнанения']);
    }

    public function actionEdit(): void
    {
        $id   = $this->route->id;
        $prod = $this->repo->edit($id);
//		$p = $prod->toArray();

        if ($prod) {
            try {
                $product = ProductFormView::edit($prod);
            } catch (\Throwable $exception) {
                $exc = $exception;
            }
            $breadcrumbs = BreadcrumbsRepository::getProductBreadcrumbs($prod, true, true);
            $this->set(compact('product', 'breadcrumbs'));
        }
        $this->assets->setProduct();
//        $this->assets->setQuill();
    }

    public function actionList(): void
    {
        $items = ProductRepository::list();
        $list  = ProductArrayFormView::list($items, 'Товары');
        $this->set(compact('list'));
    }

    public function actionChangebaseisshippable(): void
    {
        ProductService::changeBaseIsShippable($this->ajax);
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

    public function actionBaseIsShippable(): void
    {
        ProductService::changeBaseIsShippable($this->ajax);
    }

    public function actionChangepromotion()
    {
        ProductAction::changePromotion($this->ajax);
    }
}

