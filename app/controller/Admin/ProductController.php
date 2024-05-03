<?php

namespace app\controller\Admin;

use app\Actions\ProductAction;
use app\Actions\ProductFilterAction;
use app\controller\AppController;
use app\model\Product;
use app\model\ProductUnit;
use app\Repository\BreadcrumbsRepository;
use app\Repository\ProductRepository;
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
        $this->copyBaseUnits();
        if ($prod) {
//			$product = ProductFormView::edit($prod);
            $product     = ProductArrayFormView::edit($prod);
            $breadcrumbs = BreadcrumbsRepository::getProductBreadcrumbs($prod, true, true);
        }
        $this->set(compact('product', 'breadcrumbs'));
        $this->assets->setProduct();
        $this->assets->setQuill();
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

