<?php

namespace app\Services\Breadcrumbs;

use app\model\Category;
use app\view\share\card_panel\CardPanel;

class BreadcrumbsService extends BaseBreadcrumbs
{

    public function __construct(
        protected string $class = 'breadcrumbs-5',
        protected string $prefix = '/catalog',
        protected string $breadcrumbs = '',
    )
    {
    }

    public function getCategoryBreadcrumbs(Category $category): string
    {
        if (!$category) return "Категории";
        $this->category = $category;
        $this->isLastLink = false;
        $this->class = 'breadcrumbs-5';

        $arrayCategories = $this->flatCategoryParents();

        foreach ($arrayCategories as $i => $cat) {
            $slug = $cat->ownProperties->path ?? $cat->name;
            if ($i === 0) {
                if (!$this->isLastLink) {
                    $this->breadcrumbs = "<li><div>{$cat->name}</div>" . CardPanel::categoryCardPanel($category, true) . "</li>" . $this->breadcrumbs;
                } else {
                    $this->breadcrumbs = "<li><a href='{$this->prefix}/{$slug}'>{$cat->name}</a>" . CardPanel::categoryCardPanel($category, true) . "</li>" . $this->breadcrumbs;
                }
            } else {
                $this->breadcrumbs = "<li><a href='{$this->prefix}/{$slug}'>{$cat->name}</a>" . CardPanel::categoryCardPanel($category, true) . "</li>" . $this->breadcrumbs;
            }
        }
        $str = "<li><a href='{$this->prefix}'>Категории</a></li>{$this->breadcrumbs}";
        return "<nav class='{$this->class}'>{$str}</nav>";

    }

}