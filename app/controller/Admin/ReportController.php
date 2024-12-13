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

    public function __construct()
    {
        parent::__construct();
        $this->formView          = new ReportView();
        $this->productRepository = new ProductRepository();
        $this->filterService     = new ProductFilterService($this->ajax);
    }

    public function actionFilter(): void
    {
        $req = $this->ajax;
        $this->filterService->saveUserFilters($req);

        $userFilters   = empty($req) ? $this->filterService->getUserFilters() : $req;
        $products      = $this->productRepository::filter($userFilters);
        $productsTable = $this->formView->filter($products, 'Фильтр');
        $_POST         = null;
        $filterService = $this->filterService;
        if ($req) {
            Response::exitJson([
                'products' => $productsTable,
                'filterString' => $filterService->getUserFilterString(),
                'filterPanel' => $filterService->getFilterPanel()]);
        }
        $this->setVars(compact('productsTable', 'filterService'));
    }


}


