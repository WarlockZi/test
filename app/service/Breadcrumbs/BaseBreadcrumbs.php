<?php

namespace app\service\Breadcrumbs;

use app\model\Category;
use app\service\FS;
use app\view\components\cardPanel\CardPanel;

class BaseBreadcrumbs
{
    public function __construct(

        public Category $category = new Category(),
        public array    $parentsArray = [],
        public string   $class = 'breadcrumbs-5',
        public string   $namespace = '/adminsc/category',
        public bool     $isLastLink = false,
        public string   $breadcrumbs = '',
        public array   $panel = [],
        public string   $slug = '',
        public string   $href = '',
        public int      $index = 0,
    )
    {
    }

    protected function flatCategoryParents(): void
    {
        $currentCategory      = $this->category;
        $this->parentsArray[] = $currentCategory;
        if ($currentCategory->parentRecursive) {
            while ($currentCategory->parentRecursive) {
                $this->parentsArray[] = $currentCategory->parentRecursive;
                $currentCategory      = $currentCategory->parentRecursive;
            }
        }
    }

    public function getBreadcrumbs():self
    {
        $this->flatCategoryParents();
        $catCount = count($this->parentsArray) - 1;
        foreach ($this->parentsArray as $i => $cat) {
            $this->category = $cat;
            $this->slug     = $this->namespace === 'admin' ? "/adminsc/category/edit/{$cat->id}" : $cat->href;
            $this->panel    = CardPanel::categoryCardPanel($this->category->toArray(), true);
            $this->index    = $catCount - $i + 1;
            if (!$this->isLastLink && $i === 0) {
//                $this->breadcrumbs = $this->lastLink();
            } else {
//                $this->breadcrumbs = $this->link();
            }
        }
        return $this;

    }

    private function lastLink(): string
    {
        $obj = get_object_vars($this);
        return $this->fs->getContent('lastLink', compact('obj'));
    }

    private function link(): string
    {
        $obj = get_object_vars($this);
        return $this->fs->getContent('link', compact('obj'));
    }

}