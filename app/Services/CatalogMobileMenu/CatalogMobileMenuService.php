<?php

namespace app\Services\CatalogMobileMenu;

use app\core\FS;
use app\Repository\CategoryRepository;

class CatalogMobileMenuService
{
    private array $categories;
    private string $string;

    public function __construct()
    {
        $this->string     = '';
        $this->fs         = new FS(__DIR__);
        $this->categories = CategoryRepository::treeAll()->toArray();
        $this->recurse($this->categories);
    }

    public function recurse($arr)
    {
        if (empty($arr)) return;
        foreach ($arr as $i => $cat) {
            if (count($cat['children_recursive'])) {
                $self         = $this;
                $this->string .= $this->fs->getContent('li-expand', compact('cat', 'self'));
                $this->recurse($cat['children_recursive']);
                $this->string .= '</ul></li>';
            } else {
                $this->string .= $this->fs->getContent('li', compact('cat'));
            }
        }
    }

    public function get(): string
    {
        $this->string = "<ul class='nav-items nav-expand-content'>{$this->string}</ul>";
        return $this->string;
    }
}
