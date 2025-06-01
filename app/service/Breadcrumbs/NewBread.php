<?php

namespace app\service\Breadcrumbs;


class NewBread
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

    public function getParents($category): self
    {
        $this->flatParents($category);
        $this->parentsArray = array_reverse($this->parentsArray);
        return $this;
    }
}