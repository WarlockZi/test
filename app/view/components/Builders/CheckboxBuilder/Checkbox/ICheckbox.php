<?php

namespace app\view\components\Builders\CheckboxBuilder\Checkbox;

use Illuminate\Database\Eloquent\Model;

interface ICheckbox
{
    public function class(): string;
    public function lable(): string;
    public function execCheckedFn(Model $item): string;
    public function dataField(Model $item, string $field): string;
    public function dataPivotField(Model $item, string $field): string;
    public function setData(string $key, string $value): void;

}