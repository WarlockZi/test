<?php

namespace app\view\components\Builders\CheckboxBuilder\Checkbox;

interface ICheckbox
{
    public function class(): string;
    public function lable(): string;
    public function checkedFn(): string;
    public function dataField(): array;
    public function dataPivotField(): array;

}