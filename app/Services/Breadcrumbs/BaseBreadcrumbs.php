<?php

namespace app\Services\Breadcrumbs;

use app\core\FS;
use app\model\Category;
use app\view\share\card_panel\CardPanel;

class BaseBreadcrumbs
{
    public function __construct(
        protected          $fs = new FS(__DIR__),
        protected Category $category = new Category(),
        protected array    $parentsArray = [],
        protected string   $class = 'breadcrumbs-5',
        protected string   $namespace = '/adminsc/category',
        protected bool     $isLastLink = false,
        protected string   $breadcrumbs = '',
        protected string   $panel = '',
        protected string   $slug = '',
        protected string   $href = '',
    )
    {
    }

    protected function flatCategoryParents(): void
    {
        $currentCategory      = $this->category;
        $this->parentsArray[] = $currentCategory;
        if ($currentCategory->parentRecursive) {
            while ($currentCategory->parentRecursive) {
                array_push($this->parentsArray, $currentCategory->parentRecursive);
                $currentCategory = $currentCategory->parentRecursive;
            }
        }
    }

    public function getBreadcrumbs(): string
    {
        $this->flatCategoryParents();
        $catCount = count($this->parentsArray) - 1;
        foreach ($this->parentsArray as $i => $cat) {
            $this->category = $cat;
            $this->slug     = $this->namespace === 'admin' ? "/adminsc/category/edit/{$cat->id}" : $cat->href;
            $this->panel    = CardPanel::categoryCardPanel($this->category, true);
            $this->index    = $catCount - $i + 1;
            if (!$this->isLastLink && $i===0) {
                $this->breadcrumbs = $this->lastLink();
            } else {
                $this->breadcrumbs = $this->link();
            }
        }
        return $this->getWrapper();

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