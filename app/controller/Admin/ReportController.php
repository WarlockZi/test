<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\Repository\ProductRepository;
use app\Repository\ReportRepository;
use app\view\Report\Admin\ReportView;


class ReportController extends AppController
{
    private ReportRepository $repo;
    private ReportView $formView;

    public function __construct()
    {
        parent::__construct();
        $this->repo = new ReportRepository();
        $this->formView = new ReportView();
    }

    public function actionProductsnoimgInstore()
    {
        $this->view = 'productsnoimginstore';
        $p = $this->repo->noImgInStore();
        $productList = $this->formView->noImgNoInstoreList($p, 'Товары без картинок в наличии');
        $this->set(compact('productList'));
    }

    public function actionProductsBaseIsShippable()
    {
        $this->view = 'products';
        $p = $this->repo->baseIsShippable()->take(10);
        $productList = $this->formView->baseIsShippableList($p, 'Базовая отгружаемая');
        $this->set(compact('productList'));
    }

    public function actionProductsnoimgNotinstore()
    {
        $this->view = 'productswithoutimg';
        $p = $this->repo->noImgNotInStore();
        $productList = $this->formView->noImgNoInstoreList($p, 'Товары без картинок без наличия');
        $this->set(compact('productList'));
    }

    public function actionProductsNoMinUnit()
    {
        $this->view = 'productsnominunit';
        $products = $this->repo->noMinimumUnit();
        $productList = $this->formView->noMinUnitList($products, 'Товары без min упаковки');
        $this->set(compact('productList'));
    }

    public function actionProductsNoShippable()
    {
        $this->route->setView('productsnoimg');
        $products = $this->repo->noDopUnit();
        $productList = $this->formView->noMinUnitList($products, 'Товары без min упаковки');
        $this->set(compact('productList'));
    }

    public function actionTrashed()
    {
        $products = $this->repo->trashed();
        $productList = $this->formView->haveDopUnit($products, 'Товары имеющие доп единицы');
        $this->set(compact('productList'));
    }

    public function actionFilter()
    {
        $this->view = 'products';
        $productRepository = new ProductRepository();
        $products = $productRepository::filter($_POST);
        $productList = $this->formView->baseIsShippableList($products, 'Фильтр')??'';
        $this->set(compact('productList'));
    }
}


