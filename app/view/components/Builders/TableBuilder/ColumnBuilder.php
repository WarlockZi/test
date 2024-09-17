<?php


namespace app\view\components\Builders\TableBuilder;


class ColumnBuilder
{

    public $field = 'id';
    public $dataField;
    public $class;
    public $classHeader;

    public $name;
    public $type;
    public $sort;
    public $sortIcon;
    public $search;
    public $width = 'auto';
    public $hidden;
    public $contenteditable;

    public $html;
    public $function;
    public $callbackFn;
    public $functionClass;

    public $select = false;

    public static function build(string $field=''): self
    {
        $column            = new static();
        $column->field     = $field;
        $column->dataField = $field ? "data-field='{$field}'" : '';
        return $column;
    }

    public function class(string $class): self
    {
        $this->class = "class='{$class}'";
        return $this;
    }

    public function classHeader(string $class): self
    {
        $this->classHeader = "class='{$class}'";
        return $this;
    }

    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function type(string $type): self
    {
        $this->type = "data-type='{$type}'";
        return $this;
    }

    public function sort(): self
    {
        $this->sort     = 'data-sort';
        $this->sortIcon = '<div class="icon"></div>';
        return $this;
    }

    public function html(string|callable $html): self
    {
        if (is_callable($html)) {
            $this->html = $html();
        } else {
            $this->html = $html;
        }
        return $this;
    }

    public function search(): self
    {
        $this->search = '<input type="text">';
        return $this;
    }

    public function function (string $class, string $function, $params = ''): self
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

    public function hidden(): self
    {
        $this->hidden = 'hidden';
        return $this;
    }

    public function contenteditable(): self
    {
        $this->contenteditable = 'contenteditable';
        return $this;
    }

    public function getData($column, $item, $field)
    {
        if ($column->function) {
            $func = $column->function;
            return $column->functionClass::$func($column, $item, $field);
        } else if ($column->select) {
            return $column->select->get($item->$field ?? 0);
        } else if ($column->callbackFn) {
            return $column->callCallback($item);
        } else {
            return $item[$field];
        }
    }

    public function get(): self|string
    {
        try {
            $this->class       = $this->class ?? "class='cell'";
            $this->classHeader = $this->classHeader ?? "class='head'";
            $this->name        = $this->name ?? $this->field;
            return $this;
        } catch (\Throwable $exception) {
            return $exception->getMessage();
        }
    }
}