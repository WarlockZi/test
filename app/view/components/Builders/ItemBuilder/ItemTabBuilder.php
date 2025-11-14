<?php


namespace app\view\components\Builders\ItemBuilder;


use app\blade\View;

class ItemTabBuilder
{

    public string $model = '';
    public string $html = '';
    public array $tableData = [];
    public string $tabTitle = '';
    public string $field = '';
    public $blade = null;

    public static function build(string $title): self
    {
        $view        = new self();
        $view->blade = APP->get(View::class);;
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

    public function blade(array|string $templates, array $params): static
    {
        if (is_string($templates)) {
            $this->html = $this->blade->render($templates, $params);
        } else {
            foreach ($templates as $template) {

            }

        }
        $this->templates = $templates;
        return $this;
    }
}