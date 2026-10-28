<?php

namespace app\service\Breadcrumbs;


use app\model\Category;

class BreadcrumbsObj implements IBreadcrumbsStrategy
{
    public function __construct(
        private object $category,
        public bool  $lastItemIsLink= false,
        public int   $itemsCount = 0,
        public array $parentsArray = [],
    )
    {
    }

    private function flatParents(object $category): void
    {
        $currentCategory      = $category;
        $this->parentsArray[] = $currentCategory;
        if ($currentCategory->parentRecursive) {
            while ($currentCategory->parentRecursive) {
                $this->parentsArray[] = $currentCategory->parentRecursive;
                $currentCategory      = $currentCategory->parentRecursive;
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