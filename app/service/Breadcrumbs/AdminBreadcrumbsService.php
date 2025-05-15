<?php

namespace app\service\Breadcrumbs;

use app\model\Category;

class AdminBreadcrumbsService extends BaseBreadcrumbs
{
    public function __construct()
    {
        parent::__construct();
        $this->namespace    = 'admin';
        $this->categoryHref = '/adminsc/category';
        $this->class        = 'breadcrumbs-4';
    }

    public function getCategoryBreadcrumbs(Category $category): string
    {
        $this->category   = $category;
        $this->isLastLink = false;
        return $this->getBreadcrumbs();
    }

    public function getProductBreadcrumbs(Category $category): string
    {
        $this->category   = $category;
        $this->isLastLink = true;
        return $this->getBreadcrumbs();
    }
    }
