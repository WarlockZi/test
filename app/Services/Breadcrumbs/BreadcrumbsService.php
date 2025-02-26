<?php

namespace app\Services\Breadcrumbs;

use app\model\Category;

class BreadcrumbsService extends BaseBreadcrumbs
{

    public function __construct(
        protected string $breadcrumbs = '',
    )
    {
        parent::__construct();
        $this->namespace    = '';
        $this->categoryHref = '/catalog';
        $this->class        = 'breadcrumbs-5';
    }

    public function getCategoryBreadcrumbs(Category $category): string
    {
        if (!$category) return "Категории";
        $this->isLastLink = false;
        $this->category   = $category;
        return $this->getBreadcrumbs();
    }

    public function getProductBreadcrumbs(Category $category): string
    {
        if (!$category) return "Категории";
        $this->isLastLink = false;
        $this->category   = $category;
        return $this->getBreadcrumbs();
    }

    public function getWrapper(): string
    {
        $obj = get_object_vars($this);
        return $this->fs->getContent('wrapper', compact('obj'));
    }
}