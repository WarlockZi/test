<?php
declare(strict_types=1);

namespace app\view\components\Builders\ItemBuilder;


use app\blade\View;

class ItemTabBuilder
{

    public string $model = '';
    public string $html = '';
    public array $tableData = [];
    public string $tabTitle = '';
    public string $field = '';

    public static function build(string $title): self
    {
        $view        = new self();
        $view->tabTitle = $title;
        return $view;
    }

    public function html(string $html): static
    {
        $this->html = $html;
        return $this;
    }

    public function table(array $tableData): static
    {
        $this->tableData = $tableData;
        return $this;
    }

}