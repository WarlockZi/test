<?php

namespace app\view\components\Builders\CheckboxBuilder;

use app\view\components\Builders\CheckboxBuilder\Checkbox\ProductUnitCheckbox;

class ProductUnitCheckboxBuilder implements ICheckboxBuilder
{
    private ProductUnitCheckbox $chbx;

    public function __construct()
    {
        $this->chbx = new ProductUnitCheckbox;
    }

    public function setDataField(string $field): static
    {
        $this->chbx->setDataField($field);
        return $this;
    }

    public function setDataPivot(string $field): static
    {
        $this->chbx->setDataPivotField($field);
        return $this;
    }

    public function setData(string $key, string $value): static
    {
        $this->chbx->setData($key, $value);
        return $this;
    }

    public function setCheckedFn(callable $callback): static
    {
        $this->chbx->setCheckedFn($callback);
        return $this;
    }

    public function setClass(string $class): static
    {
        $this->chbx->setClass($class);
        return $this;
    }

    public function setLabel(string $class, string $label): static
    {
        $this->chbx->setLabel($class, $label);
        return $this;
    }

    public function get(): ProductUnitCheckbox
    {
        return $this->chbx;
    }
}