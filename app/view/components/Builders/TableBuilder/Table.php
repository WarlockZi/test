<?php


namespace app\view\components\Builders\TableBuilder;


use app\core\FS;
use app\core\Icon;
use Illuminate\Database\Eloquent\Collection;

class Table
{
    private string $pageTitle = '';
    private string $grid = '';
    private array $columns = [];
    private string $class = '';
    private int $take = 0;
    private bool $headEditCol = false;
    private bool $headDelCol = false;
    private string $emptyRow = '';
    private string $add = '';
    private string $dataRelation = '';
    private string $dataRelationModel = '';
    private string $dataModel = '';
    private string $html = '';
    private string $addButton = 'ajax';
    private Collection $items;

    private FS $fs;

    public static function build(Collection $items):self
    {
        $list            = new static();
        $list->items = $items;
        $list->fs        = new FS(__DIR__);

        return $list;
    }

    public function take(int $take): static
    {
        $this->take = $take;
        return $this;
    }


    public function link(string $field, string $classHeader, string $class, string $name, string $width, string $className, string $funcName)
    {
        $this->columns[$field] = ColumnBuilder::build($field)
            ->classHeader($classHeader)
            ->class($class)
            ->name($name)
            ->width($width)
            ->function($className, $funcName)
            ->get();
    }

    public function class(string $class): static
    {
        $this->class = "class = '{$class}'";
        return $this;
    }

    public function relation(string $relation, string $relationModel): static
    {
        $this->dataRelation = "data-relation='$relation'";
        $this->dataRelationModel = "data-relationModel='$relationModel'";
        return $this;
    }
    public function model(string $model): static
    {
        $this->dataModel = "data-model='$model'";
        return $this;
    }
    public function pageTitle(string $pageTitle): static
    {
        $this->pageTitle = $pageTitle;
        return $this;
    }


    public function column(ColumnBuilder $column): static
    {
        $this->columns[$column->field] = $column;
        return $this;
    }

    protected function getEditButton(int $itemId): string
    {
        if ($this->headEditCol) {
            $hidden = $itemId ? '' : 'hidden';
            return "<div {$hidden} class='edit'  $this->dataModel " .
                "data-id='{$itemId}'></div>";
        }
        return '';
    }

    protected function getDelButton(int $itemId): string
    {
        if ($this->headDelCol) {
            $hidden = $itemId ? '' : 'hidden';
            $str    = "<div {$hidden} class='del' $this->dataModel " .
                "data-id='{$itemId}'></div>";
            return $str;
        }
        return '';
    }

    protected function emptyRow(): string
    {
        $str = '';
        foreach ($this->columns as $field => $column) {

            $str .= "<div hidden {$column->class} " .
                $column->dataField .
                "data-id='0' " .
                "{$column->contenteditable}" .
                ">{$this->getEmpty($column)}</div>";
        }
        $str .= $this->getEditButton(0);
        $str .= $this->getDelButton(0);

        return $str;
    }

    public function del(): static
    {
        $this->columns['del'] = ColumnBuilder::build('del')
            ->classHeader('head del')
            ->class('del')
            ->name(Icon::trashIcon())
            ->width('50px')
            ->get();
        return $this;
    }

    public function edit(): static
    {
        $this->columns['edit'] = ColumnBuilder::build('edit')
            ->classHeader('head edit')
            ->class('edit')
            ->name(Icon::editWhite())
            ->width('50px')
            ->get();

        return $this;
    }

    public function addButton(string $ajaxOrRedirect): static
    {
        $this->addButton = $ajaxOrRedirect;
        $this->add       = $this->fs->getContent('add', ['addButton' => $this->addButton]);
        return $this;
    }

    protected function prepareGridHeader(): void
    {
        $columns = '';
        foreach ($this->columns as $colName => $column) {
            $columns .= ' ' . $column->width;
        }

        $this->grid .= "style='display: grid; grid-template-columns:{$columns}'";
    }

    protected function getData($column, $item, $field)
    {
        if ($column->function) {
            $func = $column->function;
            return $column->functionClass::$func($column, $item, $field);
        } else if ($column->select) {
            return $column->select->get($item->$field ?? 0);
        } else {
            return $item[$field];
        }
    }

    protected function getEmpty($column)
    {
        if ($column->select) {
            return $column->select->getEmpty();
        }
        return '';
    }

    public function get()
    {
        try {
            $this->emptyRow = $this->emptyRow();
            $this->prepareGridHeader();
            $this->items = $this->take ? $this->items->take($this->take) : $this->items;
            $data        = get_object_vars($this);
            return $this->fs->getContent('TableTemplate', $data);

        } catch (\Throwable $error) {
            return $error->getMessage();
        }
    }
}