<?php

namespace app\Services\Breadcrumbs;

use app\model\Category;
use app\view\share\card_panel\CardPanel;

class AdminBreadcrumbsService extends BaseBreadcrumbs
{
    public function __construct()
    {
        parent::__construct();
        $this->class    = 'breadcrumbs-4';
    }

    public function getCategoryBreadcrumbs(Category $category): string
    {
        $this->isLastLink = false;
        $this->category = $category;
        return $this->getBreadcrumbs();
//        $arrayCategories = $this->flatCategoryParents($category);
//        foreach ($arrayCategories as $i => $cat) {
//            $slug  = "edit/{$cat->id}";
//            $panel = CardPanel::categoryCardPanel($category, true);
//            if ($i === 0) {
//                $this->breadcrumbs = "<li><div>{$cat->name}</div>{$panel}</li>{$this->breadcrumbs}";
//            } else {
//                $this->breadcrumbs = "<li><a href='{$this->namespace}/{$slug}'>{$cat->name}</a>$panel</li>$this->breadcrumbs";
//            }
//        }
//        $str = "<li><a href='{$this->namespace}'>Категории</a></li>{$this->breadcrumbs}";
//        return "<nav class='{$this->class}'>{$str}</nav>";
    }

    public function getProductBreadcrumbs(Category $category): string
    {
        $this->isLastLink = true;
        $this->category = $category;

        $b = $this->getBreadcrumbs();
        return $b;

//        $prefix = self::getPrefix($admin);
//
//        $arrayCategories = $this->flatCategoryParents($category);
//        foreach ($arrayCategories as $i => $cat) {
//            $slug  = "edit/{$cat->id}";
//            $panel = CardPanel::categoryCardPanel($category, true);
//            if ($i === 0) {
//                $this->breadcrumbs = "<li><div>{$cat->name}</div>{$panel}</li>{$this->breadcrumbs}";
//            } else {
//                $this->breadcrumbs = "<li><a href='{$this->namespace}/{$slug}'>{$cat->name}</a>$panel</li>$this->breadcrumbs";
//            }
//        }
//
//        $str = "<li><a href='{$prefix}'>Категории</a></li>";
//        return "<nav class='{$class}'>{$str}</nav>";

//        $str = "<li><a href='{$this->namespace}'>Категории</a></li>{$this->breadcrumbs}";
//        return "<nav class='{$this->class}'>{$str}</nav>";
    }
}