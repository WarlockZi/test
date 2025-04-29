<?php

namespace app\service\Filters\Products;


use app\view\components\Traits\CleanString;
use app\view\Filter\FilterView;

class PanelService
{
    use CleanString;

    public function __construct(
        private readonly FilterView   $filterView = new FilterView(),
        private InitialFiltersService $initialFilters = new InitialFiltersService,
    )
    {
    }

    public function getFilterPanel(array $toFilter = [], array $toSave = []): string
    {
        $toSave  = count($toSave) ? $toSave : $toFilter;
        $filters = '';
        foreach ($this->initialFilters->get() as $filterName => $filterOptions) {
            $filters .= $this->filterView
                ->filterName($filterName)
                ->toFilter($toFilter)
                ->toSave($toSave)
                ->options($filterOptions['options'])
                ->title($filterOptions['title'])
                ->emptyOption()
                ->get();
        }
        return $this->clean($this->filterView->getProductFilterPanel($filters));
    }
}