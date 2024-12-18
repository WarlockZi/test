<?php

namespace app\controller\Admin;


use app\core\Response;
use app\model\Product;
use app\Repository\BreadcrumbsRepository;
use app\Repository\ProductFilterRepository;
use app\Repository\ProductRepository;
use app\Services\ProductService;
use app\view\Product\Admin\ProductFormView;


class ProductController extends AdminscController
{
    protected string $model = Product::class;

    private ProductRepository $repo;
    private ProductService $service;

    public function __construct()
    {
        parent::__construct();
        $this->repo    = new ProductRepository();
        $this->service = new ProductService();
    }

    public function actionSaveMainImage(): void
    {
        $file    = $_FILES['file'];
        $product = Product::find($_POST['productId']);
        Response::exitJson([$this->service->saveMainImage($file, $product) ?? 'ошибка сохнанения']);
    }

    public function actionEdit(): void
    {
        $id   = $this->route->id;
        $prod = $this->repo->edit($id);

        if ($prod) {
            $product     = ProductFormView::edit($prod);
            $breadcrumbs = BreadcrumbsRepository::getProductBreadcrumbs($prod, true, true);
            $this->setVars(compact('product', 'breadcrumbs'));
        } else {
            $product = null;
            $this->setVars(compact('product',));
        }
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

    public function actionChangebaseisshippable(): void
    {
        ProductService::changeBaseIsShippable($this->ajax);
    }

//    public function actionTrashed(): void
//    {
//        $items   = $this->repo->trashed();
//        $trashed = ProductArrayFormView::table($items, 'Удаленные товары');
//        $this->set(compact('trashed'));
//    }
}

