<?php

namespace app\controller\Admin;

use app\core\Response;
use app\Repository\ProductFilterRepository;
use app\Services\Filters\Products\FilterService;
use app\Services\Filters\Products\PanelService;
use app\Services\Filters\Products\StringService;
use app\view\Report\Admin\ReportView;


class ReportController extends AdminscController
{
    public function __construct(
        private ReportView              $formView = new ReportView(),
        private FilterService           $service = new FilterService(),
        private ProductFilterRepository $repository = new ProductFilterRepository(),
        private StringService           $stringService = new StringService(),
    )
    {
        parent::__construct();
    }

    public function actionFilter(): void
    {
        $selectFilters = $this->service->getSavedFilters();
        $filterPanel   = (new PanelService)->getFilterPanel($selectFilters);
        $filterString  = $this->service->getFilterString($selectFilters);
        $productsTable = $this->formView->filter($selectFilters, 'Фильтр');

        $this->setVars(compact('productsTable', 'filterString', 'filterPanel'));
    }

    public function actionUpdateFilter()
    {
        $req = $this->ajax;
        list($selectFilters, $toSaveFilters) = $this->service->filtersFromReq($req);
        $this->service->saveFilters($toSaveFilters);
        Response::json([
            'productsTable' => $this->formView->filter($selectFilters, 'Фильтр'),
            'filterString' => $this->service->getFilterString($selectFilters),
            'filterPanel' => (new PanelService)->getFilterPanel($selectFilters, $toSaveFilters)]);
    }

}


