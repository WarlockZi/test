<?php

namespace app\Services\Breadcrumbs;

use app\model\Category;
use app\view\share\card_panel\CardPanel;

class BaseBreadcrumbs
{
    public function __construct(
        protected string   $class = 'breadcrumbs-5',
        protected string   $namespace = '/adminsc/category',
        protected string   $breadcrumbs = '',
        protected bool     $isLastLink = false,
        protected Category $category = new Category(),
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
            $slug  = "edit/{$cat->id}";
            $panel = CardPanel::categoryCardPanel($this->category, true);
            if (!$this->isLastLink && ($catCount === $i)) {
                $this->breadcrumbs = "<li><a href='{$this->namespace}/{$slug}'>{$cat->name}</a>{$panel}</li>{$this->breadcrumbs}";
            } else {
                $this->breadcrumbs = "<li><div>{$cat->name}</div>{$panel}</li>{$this->breadcrumbs}";
            }
        }
        $str = "<li><a href='{$this->namespace}'>Категории</a></li>{$this->breadcrumbs}";
        return "<nav class='{$this->class}'>{$str}</nav>";
    }


}