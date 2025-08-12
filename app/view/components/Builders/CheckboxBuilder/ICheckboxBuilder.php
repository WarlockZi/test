<?php

namespace app\view\components\Builders\CheckboxBuilder;

interface ICheckboxBuilder
{
    public function setDataField(string $field): static;

    public function setDataPivot(string $field): static;

    public function setData(string $key, string $value): static;

    public function setCheckedFn(callable $callback): static;

    public function setClass(string $class): static;

    public function setLabel(string $class, string $label): static;

    public function get();
}