<?php

namespace app\controller\Admin;

use app\action\admin\ReportFilterProductsAction;
use app\formRequest\ProductFilterReport;
use JetBrains\PhpStorm\NoReturn;


class ReportController extends AdminscController
{
    public function __construct(
        protected ReportFilterProductsAction $actions,
    )
    {
        parent::__construct();
    }

    #[NoReturn] public function actionFilter(): void
    {
        $selectFilters = $this->actions->getSavedFilters();

        $initialFilters = $this->actions->initialFilters();
        $filterPanel    = $this->actions->panel($selectFilters);
        $filterString   = $this->actions->filterString($selectFilters);
        $filterTable    = $this->actions->table($selectFilters);

        view('admin.report.productFilter.filterIndex',
            compact(
                'initialFilters',
                'filterPanel',
                'filterString',
                'filterTable',
            ));
    }

    #[NoReturn] public function actionUpdateFilter(ProductFilterReport $request): void
    {
        $req            = $request->validated();

        [$toSave, $toSelect] = $this->actions->toSelectToSave($req);
        $this->actions->saveFilters($toSave);

        response()->json([
            'initialFilters' => $this->actions->initialFilters(),
            'filterPanel' => $this->actions->panelHtml($toSelect, $toSave),
            'filterString' => $this->actions->filterStringHtml($toSelect),
            'productsTable' => $this->actions->tableHtml($toSelect),
        ]);
    }
}


