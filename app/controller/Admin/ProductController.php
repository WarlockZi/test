<?php

namespace app\controller\Admin;


use app\core\Response;
use app\model\Product;
use app\Repository\BreadcrumbsRepository;
use app\Repository\ProductFilterRepository;
use app\Repository\ProductRepository;
use app\Services\Breadcrumbs\AdminBreadcrumbsService;
use app\Services\ProductService;
use app\view\Product\Admin\ProductFormView;


class ProductController extends AdminscController
{


    public function __construct(
        protected string                $model = Product::class,
        private ProductRepository       $repo = new ProductRepository(),
        private ProductService          $service = new ProductService(),
        private AdminBreadcrumbsService $breadcrumbsService = new AdminBreadcrumbsService(),

    )
    {
        parent::__construct();
    }

    public function actionSaveMainImage(): void
    {
        $file    = $_FILES['file'];
        $product = Product::find($_POST['productId']);
        Response::json([$this->service->saveMainImage($file, $product) ?? 'ошибка сохнанения']);
    }

    public function actionEdit(): void
    {
        $id   = $this->route->id;
        $prod = $this->repo->edit($id);

        if ($prod) {
            $product     = ProductFormView::edit($prod);
            $breadcrumbs = $this->breadcrumbsService->getProductBreadcrumbs($prod->category);
            $this->setVars(compact('product', 'breadcrumbs'));
        } else {
            $product = null;
            $this->setVars(compact('product',));
        }
    }


    public function actionFilter(): void
    {
        $res = ProductFilterRepository::make($_POST)->get();
        Response::json($res);
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

}

