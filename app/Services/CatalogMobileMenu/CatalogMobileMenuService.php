<?php

namespace app\Services\CatalogMobileMenu;

use app\Repository\CategoryRepository;

class CatalogMobileMenuService
{
    private array $categories;
    public function __construct()
    {
        $this->categories = CategoryRepository::treeAll()->toArray();
        $this->map($this->categories);
    }

    private function map(array $categories)
    {
        foreach ($categories as $category) {
            if ($category['children_recursive']) {
return "<ul class='nav-items nav-expand-content'>";
            }else{

            }

        }

    }

    public function get():string
    {
        return'';
    }

}
