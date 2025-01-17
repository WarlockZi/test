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

    protected function flatCategoryParents(): array
    {
        $cats  = [];
        $categ = $this->category;
        array_push($cats, $this->category);
        if ($categ->parentRecursive) {
            while ($categ->parentRecursive) {
                array_push($cats, $categ->parentRecursive);
                $categ = $categ->parentRecursive;
            }
        }
        return $cats;
    }

    public function getBreadcrumbs(): string
    {
        $arrayCategories = $this->flatCategoryParents();
        $catCount        = count($arrayCategories) - 1;
        foreach ($arrayCategories as $i => $cat) {
            $this->category = $cat;
            $this->slug     = $this->namespace === 'admin' ? "/adminsc/category/edit/{$cat->id}" : $cat->href;
            $this->panel    = CardPanel::categoryCardPanel($this->category, true);
            $this->index    = $catCount - $i + 1;
            if (!$this->isLastLink && ($catCount === $i)) {
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
        return $this->fs->getContent('link', compact('obj'));
    }

    private function link(): string
    {
        $obj = get_object_vars($this);
        return $this->fs->getContent('lastLink', compact('obj'));
    }

}