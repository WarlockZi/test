<?php


namespace app\view\components\ItemBuilder;


use app\view\components\Traits\CleanString;

class ItemArrayTabBuilder
{
    use CleanString;
    public string $html;
    public string $tabTitle;
    public string $field;
    private string $tabs;
    private string $noTabs;

    public static function build(string $title): ItemArrayTabBuilder
    {
        $view           = new self();
        $view->html     = '';
        $view->tabTitle = $title;
        $view->field = '';
        return $view;
    }

    public function html(string $html): ItemArrayTabBuilder
    {
        $this->html = $this->clean($html);
        return $this;
    }

    public function getHtml(): string
    {
        return $this->html;
    }

    public function getTabTitle(): string
    {
        return $this->tabTitle;
    }

    public function getField(): string
    {
        return $this->field;
    }

}