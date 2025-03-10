<?php


namespace app\view\components\MyTree;

class Tree
{
    public $items = [];

    public $parent = '';
    public $template = '';

    public $liTemplate = '';
    public $ulTemplate = '';

    public $html = '';

    public static function build(array $items)
    {
        $tree        = new self();
        $tree->items = $items;
        return $tree;
    }

    public function model(string $model)
    {
        $this->liTemplate = ROOT . "/app/view/components/MyTree/{$model}/{$model}Li.php";
        $this->ulTemplate = ROOT . "/app/view/components/MyTree/{$model}/{$model}Ul.php";
        return $this;
    }

    public function parent(string $parent)
    {
        $this->parent = $parent;
        return $this;
    }

    public function get()
    {
        $tree = $this->tree();
        return $this->showCat($tree);
    }

    public function tree(): array
    {
        $items  = self::idKeys($this->items);
        $parent = $this->parent;
        $tree   = [];
        foreach ($items as $id => &$node) {
            if ((isset($node[$parent]) && !(bool)$node[$parent]) || $node[$parent] == null) {
                if (count($node) > 1)
                    $tree[$id] = &$node;
            } elseif (isset($node[$parent]) && $node[$parent]) {
                $items[(int)$node[$parent]]['childs'][$id] = &$node;
            }
        }
        return $tree;
    }

    public static function idKeys(array $items)
    {
        $all = [];
        foreach ($items as $key => $v) {
            $all[$v['id']] = $v;
        }
        return $all;
    }

    function ul($item, $level)
    {
        ob_start();
        include $this->ulTemplate;
        return ob_get_clean();
    }

    function li($item, $level)
    {
        ob_start();
        include $this->liTemplate;
        return ob_get_clean();
    }

    function tplMenu($item, $level)
    {
        $ul    = isset($item['childs']);
        $tag   = $ul ? "ul" : 'li';
        $class = $ul ? "" : '';

        $menu = "<{$tag} {$class}>";
        $menu .= $ul
            ? $this->ul($item, $level)
            : $this->li($item, $level);

        if ($ul) {
            $menu .=
                "<ul class='level-{$level}'>" .
                $this->showCat($item['childs'], $level) .
                '</ul>';
        }
        $menu .= "</{$tag}>";
        return $menu;
    }

    function showCat($tree, $level = 0)
    {
        $string = '';
        $level++;
        foreach ($tree as $item) {
            $string .= $this->tplMenu($item, $level);
        }
        return $string;
    }

    private function buildLi($item, $level)
    {
        $this->html .= $this->liDecortor($item, $level);
    }

    private function liDecortor($item, $level)
    {
        $level++;
        $content = $this->getLiContent($item, $level);
        return "<li class='level-{$level}'>{$content}</li>";
    }

    private function getLiContent($item, $level)
    {
        ob_start();
        include $this->liTemplate;
        return ob_get_clean();
    }

    public function buildHtml($tree)
    {
        foreach ($tree as $index => $item)
            if (isset($item['childs'])) {
                $this->buildUl($item, 0);
            } else {
                $this->buildLi($item, 0);
            }
    }

    private function buildUl($item, $level)
    {
        $level++;
        $content    = $this->getUlContent($item, $level);
        $this->html .= "<ul class='level-{$level}>{$content}</ul>";
    }

    private function getUlContent($item, $level)
    {
        ob_start();
        include $this->ulTemplate;
        return ob_get_clean();
    }

}