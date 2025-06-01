<?php

namespace app\controller\Admin;

use app\action\admin\ReportFilterProductsAction;
use app\service\Filters\Products\FilterService;
use app\service\Response;
use JetBrains\PhpStorm\NoReturn;


class ReportController extends AdminscController
{
    public function __construct(
        protected ReportFilterProductsAction $actions,
        private readonly FilterService       $service,
    )
    {
        parent::__construct();
    }

    #[NoReturn] public function actionFilter(): void
    {
        $selectFilters = $this->actions->getSavedFilters();
        $filterPanel   = $this->actions->getFilterPanel($selectFilters);
        $filterString  = $this->service->getFilterString($selectFilters);
        $productsTable = $this->actions->filter($selectFilters);

        view('admin.report.productFilter.filterIndex',
            compact('filterPanel',
                'productsTable',
                'filterString'));
    }

    public function actionUpdateFilter(): void
    {
        $req = $this->ajax;
        list($selectFilters, $toSaveFilters) = $this->service->filtersFromReq($req);
        $this->service->saveFilters($toSaveFilters);
        response()->json([
            'productsTable' => $this->actions->filter($selectFilters),
            'filterString' => $this->service->getFilterString($selectFilters),
            'filterPanel' => $this->actions->getFilterPanel($selectFilters)
            ]);
    }

}


