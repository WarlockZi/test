<?php

namespace app\service\Breadcrumbs;


use app\model\Category;

class NewBread
{
    public function __construct(
        public bool  $lastItemIsLink= false,
        public int   $itemsCount = 0,
        public array $parentsArray = [],
    )
    {
    }

    protected function flatParents(Category $category): void
    {
        $currentCategory      = $category;
        $this->parentsArray[] = $currentCategory;
        if ($currentCategory['parentRecursive']) {
            while ($currentCategory['parentRecursive']) {
                $this->parentsArray[] = $currentCategory['parentRecursive'];
                $currentCategory      = $currentCategory['parentRecursive'];
            }
        }
        $this->itemsCount = count($this->parentsArray);
    }

    public function getParents(Category $category, bool $lastItemIsLink = false): self
    {
        $this->lastItemIsLink = $lastItemIsLink;

        $this->flatParents($category);
        $this->parentsArray = array_reverse($this->parentsArray);
        return $this;
    }
}