<?php

namespace app\Services\Breadcrumbs;

use app\model\Category;

class AdminBreadcrumbsService extends BaseBreadcrumbs
{
    public function __construct()
    {
        parent::__construct();
        $this->namespace = 'admin';
        $this->categoryHref = '/adminsc/category';
        $this->class    = 'breadcrumbs-4';
    }

    public function getCategoryBreadcrumbs(Category $category): string
    {
        $this->isLastLink = false;
        $this->category = $category;
        return $this->getBreadcrumbs();
    }

    public function getProductBreadcrumbs(Category $category): string
    {
        $this->isLastLink = true;
        $this->category = $category;
        return $this->getBreadcrumbs();
    }

    public function getWrapper(): string
    {
        $obj = get_object_vars($this);
        return $this->fs->getContent('wrapper', compact('obj'));
    }
}