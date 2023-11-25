<?php

namespace app\controller\Admin;

use app\Actions\ProductAction;
use app\controller\AppController;
use app\model\Product;
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

	public function actionEdit()
	{
		$id = $this->route->id;
		$prod = ProductRepository::edit($id);
		if ($prod) {
			$product = ProductFormView::edit($prod);
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
		if (!$productId) $this->exitWithPopup('Ошибка - не id продукта');
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
