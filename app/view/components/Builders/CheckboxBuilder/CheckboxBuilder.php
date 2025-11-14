<?php


namespace app\view\components\Builders\CheckboxBuilder;


use app\blade\View;

class CheckboxBuilder
{
    public string $field = '';
    public string $checked = '';
    public $checkedFFn;
    public string $data = '';
    public array $pivotData = [];
    public array $dataField = [];
    public array $dataPivotField = [];
    public array $itemData = [];
    public string $class = '';
    public string $id = '';
    public string $for = '';
    public string $label = '';
    public string $labelClass = '';
    public string $emptyRow = '';


    public static function build(): CheckboxBuilder
    {
        return new self();
    }

    public function field(string $field): static
    {
        $this->field = "data-field=$field";
        return $this;
    }
    public function checked(): static
    {
        $this->checked = "checked";
        return $this;
    }
    public function checkedFn(callable $callback): static
    {
        $this->checkedFFn = $callback;
        return $this;
    }

    public function pivotData(string $field): static
    {
        $this->pivotData[] = $field;
        return $this;
    }

    public function getPivotData($item, $pivotDataIndex)
    {
        $field = $this->pivotData[$pivotDataIndex];
        return $item->$field;
    }

    public function itemData(string $field): static
    {
        $this->itemData[] = $field;
        return $this;
    }

    public function getItemData($item, $itemDataIndex)
    {
        $field = $this->itemData[$itemDataIndex];
        return $item->$field;
    }

    public function data(string $postfix, string|null $value): static
    {
        $this->data .=  "data-$postfix=$value ";
        return $this;
    }

    public function class(string $class): static
    {
        $this->class = "class ='$class'";
        return $this;
    }

    public function label(string $class, string $label): static
    {
        $this->labelClass = "class ='{$class}'";
        $this->label      = $label;

        $this->for = $this->field;
        $this->id  = $this->field;

        return $this;
    }

    public function get(): self
    {
//
//        $checkbox = get_object_vars($this);
//        $view  =  APP->get(View::class);
//        $html = $view->render('admin.components.checkbox.checkbox', compact('checkbox'));
//        $this->emptyRow = $html;
        return $this;
    }
    public function toHtml(): string
    {
        $checkbox = $this;
//        $checkbox = get_object_vars($this);
        $view  =  APP->get(View::class);
        $html = $view->render('admin.components.checkbox.checkbox', compact('checkbox'));
        $this->emptyRow = $html;
        return $html;
    }
}