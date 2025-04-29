<?php

namespace app\service\Breadcrumbs;

use app\model\Category;
use app\service\FS;

class BreadcrumbsService extends BaseBreadcrumbs
{

    public function __construct(
        public string $breadcrumbs = '',
        public string $categoryHref = '',
    )
    {

        parent::__construct();
        $this->namespace    = '';
        $this->categoryHref = '/catalog';
        $this->class        = 'breadcrumbs-5';
    }

    public function getCategoryBreadcrumbs(Category $category)
    {
        if (!$category) return "Категории";
        $this->isLastLink = false;
        $this->category   = $category;
        return $this->getBreadcrumbs();
    }

    public function getProductBreadcrumbs(Category $category)
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