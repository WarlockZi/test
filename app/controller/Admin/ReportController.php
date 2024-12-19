<?php

namespace app\controller\Admin;

use app\core\Response;
use app\Repository\ProductFilterRepository;
use app\Services\Filters\ProductFilterService;
use app\view\Report\Admin\ReportView;


class ReportController extends AdminscController
{
    private ReportView $formView;
    private ProductFilterService $service;
    private ProductFilterRepository $repository;

    public function __construct()
    {
        parent::__construct();
        $this->formView   = new ReportView();
        $this->repository = new ProductFilterRepository();
        $this->service    = new ProductFilterService();
    }

    public function actionFilter(): void
    {
        $req = $this->ajax;
        if (empty($req)) {
            $selectFilters = $this->service->getSavedFilters();
            $filterPanel   = $this->service->getFilterPanel($selectFilters);
        } else {
            list($selectFilters, $toSaveFilters) = $this->service->filtersFromReq($req);
            $filterString = $this->service->getFilterString($selectFilters);
            $filterPanel  = $this->service->getFilterPanel($selectFilters, $toSaveFilters);
        }
//            $filters     = $this->service->filtersFromReq($req);

        $filterString = $this->service->getFilterString($selectFilters);
        $checked      = [];

        $productsTable = $this->formView->filter($selectFilters, 'Фильтр');

        if ($req) {
            Response::exitJson([
                'productsTable' => $productsTable,
                'filterString' => $filterString,
                'filterPanel' => $filterPanel]);
        }
        $this->setVars(compact('productsTable', 'filterString', 'filterPanel'));
    }


}


