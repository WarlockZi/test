<?php


namespace app\view\components\Builders\TableBuilder;


use app\view\components\Builders\CheckboxBuilder\CheckboxBuilder;
use app\view\components\Traits\CleanString;

class ColumnBuilder
{
    use CleanString;

//    public string $field = '';
    public string $dataAttributes = '';
    public $dataField;
    public string $class = "class='cell left'";
    public string $classHeader;

    public string $name;
//    public $type;
    public $sort;
    public $sortIcon;
    public $search;
    public string $width = 'auto';
    public $hidden;
    public $contenteditable;
    public $pivot;
    public string $attach = '';

    public $function;
    public $callbackFn;
    public $component;
    public $functionClass;

    public bool $select = false;
    public mixed $emptyRow = '';

    public static function build(string $name): self
    {
        $column       = new static();
        $column->name = $name;
        return $column;
    }
    public function data(array $data): self
    {
        foreach ($data as $key => $value) {
            $this->dataAttributes.="data-$key=$value ";
        }
        return $this;
    }
    public function emptyRow(callable|string $emptyRow): self
    {
        if (is_callable($emptyRow)) {
            $content        = $this->clean(call_user_func($emptyRow));
            $this->emptyRow = $content;
        } else {
            $this->emptyRow = $emptyRow;
        }
        return $this;
    }

    public function class(string $class): self
    {
        $this->class = "class='{$class}'";
        return $this;
    }

//    public function pivot(string $pivotField): self
//    {
//        $this->pivot = "data-pivot='{$pivotField}'";
//        return $this;
//    }
//    public function type(string $type): self
//    {
//        $this->type = "data-type='{$type}'";
//        return $this;
//    }
    public function classHeader(string $class): self
    {
        $this->classHeader = "class='{$class}'";
        return $this;
    }

    public function headerIcon(string $icon): self
    {
        $this->name = $icon;
        return $this;
    }

//

    public function sort(): self
    {
        $this->sort     = 'data-sort';
        $this->sortIcon = '<div class="icon"></div>';
        return $this;
    }

    public function search(): self
    {
        $this->search = '<input type="text" data-search>';
        return $this;
    }

    public function function (string $class, string $function): self
    {
        $this->functionClass = $class;
        $this->function      = $function;
        return $this;
    }

    public function callback($callback): self
    {
        $this->callbackFn = $callback;
        return $this;
    }

    public function callCallback($attr)
    {
        return call_user_func($this->callbackFn, $attr);
    }

    public function width(string $width): self
    {
        $this->width = $width;
        return $this;
    }

    public function contenteditable(): self
    {
        $this->contenteditable = 'contenteditable';
        return $this;
    }

    public function component($component): self
    {
        $this->component = $component;
        return $this;
    }

    private function handleCheckbox($checkbox, $item): void
    {
        $checkedFFn        = $checkbox->checkedFFn;
        $checkbox->checked = $checkedFFn($item) ? 'checked' : '';
    }

    public function getData($column, $item, $field)
    {
        if ($column->component) {
            if ($column->component instanceof CheckboxBuilder) {
                $this->handleCheckbox($column->component, $item);
            }
        } elseif ($column->function) {
            $func = $column->function;
            return $column->functionClass::$func($column, $item, $field);
        } else if ($column->select) {
            return $column->select->get($item->$field ?? 0);
        } else if ($column->callbackFn) {
            return $column->callCallback($item);
        } else {
            return $item[$field] ?? '';
        }
    }


    public function get(): self|string
    {
        $this->class       = $this->class ?? "class='cell'";
        $this->classHeader = $this->classHeader ?? "class='head'";
        return $this;
    }
}