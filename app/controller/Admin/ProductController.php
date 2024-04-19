<?php

namespace app\controller\Admin;

use app\Actions\ProductAction;
use app\Actions\ProductFilterAction;
use app\controller\AppController;
use app\core\DB;
use app\model\Product;
use app\model\ProductUnit;
use app\model\Unit;
use app\model\Unitable;
use app\Repository\BreadcrumbsRepository;
use app\Repository\ProductRepository;
use app\view\Product\ProductFormView;


class ProductController extends AppController
{
	public $model = Product::class;

	public function __construct()
	{
		parent::__construct();
	}

    private function copyUnits()
    {
        $unitables = Unitable::all()->toArray();
        foreach ($unitables as $unitable){
            $model = [
                'product_1s_id'=>$unitable['product_id'],
                'unit_id'=>$unitable['unitable_id'],
                'multiplier'=>$unitable['multiplier'],
                'is_main'=>$unitable['main']?1:null,
            ];
            ProductUnit::create($model);
        }
    }

	public function actionEdit()
	{
        $this->copyUnits();
		$id = $this->route->id;
		$prod = ProductRepository::edit($id);
		$p = $prod->toArray();
		if ($prod) {
			$product = ProductFormView::edit($prod);
//			$product = ProductFormView::edit($prod);
			$breadcrumbs = BreadcrumbsRepository::getProductBreadcrumbs($prod, true, true);
		}
		$this->set(compact('product', 'breadcrumbs'));
		$this->assets->setProduct();
		$this->assets->setQuill();
	}

	public function actionList()
	{
		$items = ProductRepository::list();
		$list = ProductFormView::list($items);
		$this->set(compact('list'));
	}

	public function actionTrashed()
	{
		$items = ProductRepository::trashed();
		$trashed = ProductFormView::trashed($items);
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
