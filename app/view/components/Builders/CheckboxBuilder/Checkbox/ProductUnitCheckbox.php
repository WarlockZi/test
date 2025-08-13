<?php

namespace app\view\components\Builders\CheckboxBuilder\Checkbox;

use Illuminate\Database\Eloquent\Model;

class ProductUnitCheckbox implements ICheckbox
{
    public array $dataField = [];
    public array $dataPivotField = [];
    public array $data = [];
    private $checkeFn;
    private string $labelClass;
    private string $label;
    private string $class;

    public function setDataField(string $field): void
    {
        $this->dataField[] = $field;
    }

    public function setDataPivotField(string $field): void
    {
        $this->dataField[] = $field;
    }

    public function setData(string $key, string $value): void
    {
        $this->data[$key] = $value;
    }

    public function setLabel(string $label, string $class): void
    {
        $this->label      = $label;
        $this->labelClass = $class;
    }

    public function setCheckedFn(callable $callable): void
    {
        $this->checkeFn = $callable;
    }

    public function setClass(callable $class): void
    {
        $this->class = $class;
    }

// getters
    public function class(): string
    {
        return "class='{$this->class}'";
    }

    public function lable(): string
    {
        return "lable='{$this->lable}'";
    }


    public function execCheckedFn(Model $item): string
    {
        $fn  = $this->checkeFn;
        $res = (boolean)$fn($item);
        return $res ? 'checked' : '';
    }

    public function dataField(Model $item, string $field): string
    {
        return (string)$item->$field;
    }

    public function dataPivotField(Model $item, string $field): string
    {
        return (string)$item->$field;
    }

}