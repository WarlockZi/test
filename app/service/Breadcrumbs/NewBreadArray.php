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
            $i = 1;
            while ($currentCategory['parent_recursive']) {
                $this->parentsArray[$i] = $currentCategory['parent_recursive'];
                $this->parentsArray[$i]['own_properties'] = $currentCategory['own_properties'];
                $currentCategory      = $currentCategory['parent_recursive'];
                $i++;
            }
        }
        $this->itemsCount = count($this->parentsArray);
    }

    public function getParents(array $category, bool $lastItemIsLink = false): array
    {
        $this->lastItemIsLink = $lastItemIsLink;

        $this->flatParents($category);
        $this->parentsArray = array_reverse($this->parentsArray);
        return get_object_vars($this);
    }
}