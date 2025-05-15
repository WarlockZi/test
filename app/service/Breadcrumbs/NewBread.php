<?php

namespace app\service\Breadcrumbs;

use app\model\Category;

class NewBread
{
    public function __construct(
        public bool  $lastItemIsLink,

        public int   $itemsCount = 0,
        public array $parentsArray = [],
    )
    {
        $this->itemsCount = count($this->parentsArray);
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
    }

    public function getParents($category): self
    {
        $this->flatParents($category);
        $this->parentsArray = array_reverse($this->parentsArray);
        return $this;
    }
}