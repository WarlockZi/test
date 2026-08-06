<?php

namespace app\controller\Admin;


use app\action\admin\ProductAction;
use app\blade\views\product\ProductFormView;
use app\formRequest\StoreProductMainImageRequest;
use app\model\Product;
use app\model\ProductUnit;
use app\repository\ProductFilterRepository;
use app\repository\ProductRepository;
use app\service\AuthService\Auth;
use app\service\Breadcrumbs\NewBreadArray;
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
        $prod        = $this->repo->edit($request->id);
        if (!$prod) {
            view('admin.product.notFound');
        }
        $breadcrumbs = (new NewBreadArray(true))->getParents($prod->category->toArray());
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
    public function actionDelete(IRequest $request): void
    {
        if ($request->body()['relation']['name']==='units') {

            $product_id = $request->body()['id'];
            $product_1s_id = Product::select('1s_id')->find($product_id)['1s_id'];
            $unit_id = $request->body()['relation']['id'];
            $productUnit = ProductUnit::where([
                'product_1s_id' => $product_1s_id,
                'unit_id' => $unit_id
            ])->first();
            $isFromS = $productUnit->is_from_1s;
            if ($isFromS) {
                $user = Auth::getUser();
                $olia = $user->isOlya();
                if (!$olia) response()->json(['popup'=>'Удалять единицы из 1с может только Оля Ордина']);
            }
        }
        parent::actionDelete($request);
    }
    public function actionChangeunit(IRequest $request): void
    {
        $this->actions->changeUnit($request->body());
    }
    public function actionChangeunitprice(IRequest $request): void
    {
        $this->actions->changeUnitPrice($request->body);
    }
    public function actionChangepromotion(IRequest $request): void
    {
        $this->actions->changePromotion($request);
    }

}

