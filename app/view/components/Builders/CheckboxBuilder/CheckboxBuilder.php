<?php


namespace app\view\components\Builders\CheckboxBuilder;


class CheckboxBuilder
{
    public string $field = '';
    public string $checked = '';
    public $checkedFFn;
    public string $data = '';
    public array $itemData = [];
    public array $pivotData = [];
    public string $class = '';
    public string $id = '';
    public string $for = '';
    public string $label = '';
    public string $labelClass = '';


    public static function build(): CheckboxBuilder
    {
        return new self();
    }

    public function field(string $field): static
    {
        $this->field = "data-field=$field";
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
        $this->data .= $this->data . "data-$postfix=$value ";
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
        return $this;
    }

}