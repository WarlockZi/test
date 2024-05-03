<?php

namespace app\controller\Admin;

use app\Actions\ProductAction;
use app\Actions\ProductFilterAction;
use app\controller\AppController;
use app\model\Product;
use app\model\ProductUnit;
use app\Repository\BreadcrumbsRepository;
use app\Repository\ProductRepository;
use app\Services\Logger\FileLogger;
use app\view\Product\ProductArrayFormView;
use app\view\Product\ProductFormView;


class ProductController extends AppController
{
    public $model = Product::class;

    public function __construct()
    {
        parent::__construct();
    }

    public function actionEdit()
    {
        $id   = $this->route->id;
        $prod = ProductRepository::edit($id);
//		$p = $prod->toArray();

//        $this->copyBaseUnits();
        $this->cleanBaseUnits();
        if ($prod) {
            $product     = ProductArrayFormView::edit($prod);
            $breadcrumbs = BreadcrumbsRepository::getProductBreadcrumbs($prod, true, true);
        }
        $this->set(compact('product', 'breadcrumbs'));
        $this->assets->setProduct();
        $this->assets->setQuill();
    }

    private function cleanBaseUnits()
    {
        $duplicates = ProductUnit::select('product_1s_id', 'unit_id', 'multiplier', 'is_base')
            ->groupBy('product_1s_id', 'unit_id', 'multiplier', 'is_base')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        $logger = new FileLogger();
        $logger->write('duplicates->count -'.$duplicates->count());
        if (!$duplicates->count()) return null;
        foreach ($duplicates as $duplicate) {
            $res = ProductUnit::where('product_1s_id', $duplicate->product_1s_id)
                ->where('unit_id', $duplicate->unit_id)
                ->where('multiplier', $duplicate->multiplier)
                ->where('is_base', $duplicate->is_base)
                ->orderBy('unit_id', 'asc')
                ->skip(1)
                ->delete();
        }
        return true;
    }

    private function copyBaseUnits()
    {
        $p = Product::all()->toArray();
        foreach ($p as $pr) {
            $model = [
                'product_1s_id' => $pr['1s_id'],
                'unit_id' => $pr['base_unit'],
                'multiplier' => 1,
                'is_base' => 1,
            ];
            ProductUnit::create($model);
        }
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
        $this->exitJson($res);
    }

    public function actionChangeval()
    {
        ProductAction::changeVal($this->ajax);
    }

    public function actionChangeunit()
    {
        ProductAction::changeUnit($this->ajax);
    }

    public function actionAttachmainimage()
    {
        if (!$_FILES['file']) $this->exitWithPopup('Ошибка - не передан файл');
        $productId = $_POST['productId'];
        if (!$productId) $this->exitWithPopup('Ошибка - нет id продукта');
        $srcs = ProductAction::attachMainImage($_FILES['file'], $productId);
        if ($srcs) $this->exitJson([$srcs]);
    }

    public function actionChangepromotion()
    {
        ProductAction::changePromotion($this->ajax);
    }

    public function actionSetbaseequalmainunit()
    {
        if (ProductAction::setBaseEqualMainUnit($this->ajax)) {
            $this->exitWithPopup('Обновлено');
        }
        $this->exitJson(['popup' => 'ошибка']);
    }
}

