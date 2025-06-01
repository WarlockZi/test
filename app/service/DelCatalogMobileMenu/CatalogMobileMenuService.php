<?php

namespace app\service\DelCatalogMobileMenu;

use app\blade\View;

class CatalogMobileMenuService
{
    private View $view;
    private string $string;
    private array $categories = [];


    public function __construct(View $view, string $string, array $categories)
    {
        $this->view       = $view;
        $this->string     = $string;
        $this->categories = $categories;
        $this->recurse();

    }

    public function recurse(): void
    {
        if (empty($this->categories)) return;
        foreach ($this->categories as $i => $cat) {
            if (count($cat['children_recursive'])) {
                $self         = $this;
                $this->string .= $this->view->render('li-expand', compact('cat', 'self'));
                $this->recurse($cat['children_recursive']);
                $this->string .= '</ul></li>';
            } else {
                $this->string .= $this->view->render('li', compact('cat'));
            }
        }
    }

    public function get(): string
    {
        $this->string = "<ul class='nav-items nav-expand-content'>{$this->string}</ul>";
        return $this->string;
    }
}
