<?php

namespace app\service\Breadcrumbs;


use app\model\Category;

class NewBreadArray
{
    public function __construct(
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

    public function getParents(array $category): array
    {
//        $this->lastItemIsLink = $lastItemIsLink;

        $this->flatParents($category);
        $this->parentsArray = array_reverse($this->parentsArray);
        return get_object_vars($this);
    }
}