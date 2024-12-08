<?php

namespace app\controller\Admin;

use app\core\Response;
use app\Repository\ProductRepository;
use app\Repository\ReportRepository;
use app\Services\Filters\ProductFilterService;
use app\view\Report\Admin\ReportView;


class ReportController extends AdminscController
{
    private ReportRepository $repo;
    private ReportView $formView;
    private ProductRepository $productRepository;
    private ProductFilterService $productFilterService;

    public function actionFilter(): void
    {
        $req = [];

        if (!empty($_POST)) {
            $req = $_POST;
            $this->productFilterService->saveUserFilters($req);
        }

        $filterService = $this->productFilterService->get();
        $products      = $this->productRepository::filter($req);
        $productsTable   = $this->formView->filter($products, 'Фильтр');
        if ($_POST) {
            Response::exitJson([
                'products' => $productsTable,
                'filtersSting' => $filterService->getUserFilterString(),
                'filterPanel'=>$filterService->getFilterPanel()]);
        }
        $this->setVars(compact('productsTable', 'filterService'));
    }

    public function __construct()
    {
        parent::__construct();
        $this->repo                 = new ReportRepository();
        $this->formView             = new ReportView();
        $this->productRepository    = new ProductRepository();
        $this->productFilterService = new ProductFilterService();
    }
}


