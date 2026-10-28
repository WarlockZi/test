<?php

namespace app\service\Breadcrumbs;


class BreadcrumbsArray  implements IBreadcrumbsStrategy
{
    public function __construct(
        private array $category,
        public bool  $lastItemIsLink= false,
        public int   $itemsCount = 0,
        public array $parentsArray = [],
    )
    {
    }

    protected function flatParents(array $category): void
    {
        $currentCategory      = $category;
        $this->parentsArray[] = $currentCategory;
        if ($currentCategory['parent_recursive']) {
            while ($currentCategory['parent_recursive']) {
                $this->parentsArray[] = $currentCategory['parent_recursive'];
                $currentCategory      = $currentCategory['parent_recursive'];
            }
        }
        $this->itemsCount = count($this->parentsArray);
    }

    public function generate(): array
    {
        $this->flatParents($this->category);
        $this->parentsArray = array_reverse($this->parentsArray);
        unset($this->category);
        return get_object_vars($this);
    }
}