<?php

namespace app\view\components\Builders\CheckboxBuilder\Checkbox;

class FeedbackCheckbox implements ICheckbox
{
    private array $dataField;
    private array $dataPivotField;
    private $checkeFn;
    private string $labelClass;
    private string $label;
    private string $class;
    public function setDataField(string $field): void
    {
        $this->dataField[] = ($field);
    }
    public function setDataPivotField(string $field): void
    {
        $this->dataPivotField[] = ($field);
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

    public function checkedFn(): string
    {
        $res = (boolean)($this->checkeFn)($item);
        return $res?'checked':'';
    }

    public function dataField(): array
    {
        return $this->dataField;
    }

    public function dataPivotField(): array
    {
        return $this->dataPivotField;
    }
}