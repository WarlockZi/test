<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\Repository\ProductRepository;
use app\Repository\ReportRepository;
use app\Services\Filters\ProductFilterService;
use app\view\Report\Admin\ReportView;


class ReportController extends AppController
{
    private ReportRepository $repo;
    private ReportView $formView;
    private ProductRepository $productRepository;
    private ProductFilterService $productFilterService;

    public function actionFilter():void
    {
        if (!empty($_POST)) {
            $this->productFilterService->saveUserFilters($_POST);
        }

        $filterService = $this->productFilterService->get();
        $products      = $this->productRepository::filter($_POST);
        $productList   = $this->formView->filter($products, 'Фильтр');
        $this->setVars(compact('productList', 'filterService'));
    }

    public function __construct()
    {
        parent::__construct();
        $this->repo                 = new ReportRepository();
        $this->formView             = new ReportView();
        $this->productRepository    = new ProductRepository();
        $this->productFilterService = new ProductFilterService();
    }

//    public function actionProductsnoimgInstore()
//    {
//        $this->view  = 'productsnoimginstore';
//        $p           = $this->repo->noImgInStore();
//        $productList = $this->formView->noImgNoInstoreList($p, 'Товары без картинок в наличии');
//        $this->set(compact('productList'));
//    }
//
//    public function actionProductsBaseIsShippable()
//    {
//        $this->view  = 'products';
//        $p           = $this->repo->baseIsShippable();
//        $productList = $this->formView->baseIsShippableList($p, 'Базовая отгружаемая');
//        $this->set(compact('productList'));
//    }
//
//    public function actionProductsnoimgNotinstore()
//    {
//        $this->view  = 'productswithoutimg';
//        $p           = $this->repo->noImgNotInStore();
//        $productList = $this->formView->noImgNoInstoreList($p, 'Товары без картинок без наличия');
//        $this->set(compact('productList'));
//    }
//
//    public function actionProductsNoMinUnit()
//    {
//        $this->view  = 'productsnominunit';
//        $products    = $this->repo->noMinimumUnit();
//        $productList = $this->formView->noMinUnitList($products, 'Товары без min упаковки');
//        $this->set(compact('productList'));
//    }
//
//    public function actionProductsNoShippable()
//    {
//        $this->view  = 'products';
//        $products    = $this->repo->noDopUnit();
//        $productList = $this->formView->noMinUnitList($products, 'Товары без min упаковки');
//        $this->set(compact('productList'));
//    }
//
//    public function actionTrashed()
//    {
//        $products    = $this->repo->trashed();
//        $productList = $this->formView->haveDopUnit($products, 'Товары имеющие доп единицы');
//        $this->set(compact('productList'));
//    }

}


