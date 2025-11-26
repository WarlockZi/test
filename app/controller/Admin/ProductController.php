<?php

namespace app\controller\Admin;


use app\action\admin\ProductAction;
use app\blade\views\product\ProductFormView;
use app\formRequest\StoreProductMainImageRequest;
use app\model\Product;
use app\repository\ProductFilterRepository;
use app\repository\ProductRepository;
use app\service\Router\IRequest;
use Exception;
use JetBrains\PhpStorm\NoReturn;


class ProductController extends AdminscController
{
    public function __construct(
        private readonly ProductAction           $actions,
        private readonly ProductFilterRepository $filterRepo,
        private ProductRepository                $repo,
        protected string                         $model = Product::class,
    )
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    #[NoReturn] public function actionSaveMainImage(StoreProductMainImageRequest $request): void
    {

        $mainImage = $this->actions->saveMainImage($request->validated());
        response()->json(compact('mainImage'));
    }

    #[NoReturn] public function actionEdit(IRequest $request): void
    {
        exit(phpinfo());
        $prod        = $this->repo->edit($request->id);
        $breadcrumbs = $this->actions->getBreadcrumbs($prod->category, false);
        $catItem     = ProductFormView::edit($prod);
        view('admin.product.edit', compact('catItem', 'breadcrumbs'));
    }

    #[NoReturn] public function actionFilter(IRequest $request): void
    {
        $res = $this->filterRepo->filterProducts($request);
        response()->json($res);
    }

    public function actionChangeval(IRequest $request)
    {
        $this->actions->changeVal($request);
    }

    public function actionDeleteunit(IRequest $request): void
    {
        $this->actions->deleteUnit($request);
    }

    public function actionChangeunit(IRequest $request): void
    {
        $this->actions->changeUnit($request);
    }
    public function actionChangeunitprice(IRequest $request): void
    {
        $this->actions->changeUnitPrice($request->body);
    }
    public function actionChangepromotion(IRequest $request): void
    {
        $this->actions->changePromotion($request);
    }

//    public function actionChangebaseisshippable(IRequest $request): void
//    {
//        $this->actions->changeBaseIsShippable($request);
//    }
//    public function actionBaseIsShippable(IRequest $request): void
//    {
//        $this->actions->changeBaseIsShippable($request);
//    }

}

