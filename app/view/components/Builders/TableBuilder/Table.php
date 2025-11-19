<?php


namespace app\view\components\Builders\TableBuilder;


use app\service\Fs\FS;
use app\view\components\Builders\CheckboxBuilder\CheckboxBuilder;
use app\view\components\Icon\Icon;
use app\view\components\Traits\CleanString;
use Illuminate\Database\Eloquent\Collection;

class Table
{
    use CleanString;

    private string $pageTitle = '';
    private array $header = [];
    private string $grid = '';
    private array $columns = [];
    private string $class = '';
    private int $take = 0;
    private bool $headEditCol = false;
    private bool $headDelCol = false;
    private string $emptyRow = '';
    private bool $add = false;
    private string $pivot = '';
    private string $dataAttributes = '';
//    private string $dataRelation = '';
//    private string $dataModel = '';
//    private string $dataRelationType = '';
    private string $html = '';
    private bool $addButton = false;
    private Collection|null $items;

    public static function build(Collection $items): self
    {
        $table        = new static();
        $table->items = $items;

        return $table;
    }

    public function take(int $take): static
    {
        $this->take = $take;
        return $this;
    }


    public function link(string $field, string $classHeader, string $class, string $name, string $width, string $className, string $funcName): void
    {
        $this->columns[$field] = ColumnBuilder::build($field)
            ->classHeader($classHeader)
            ->class($class)
//            ->name($name)
            ->width($width)
            ->function($className, $funcName)
            ->get();
    }

    public function class(string $class): static
    {
        $this->class = "class = '{$class}'";
        return $this;
    }

    public function data(array $data): self
    {
        foreach ($data as $key => $value) {
            $this->dataAttributes.="data-$key=$value ";
        }
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

    public function header(array $header): static
    {
        $this->header = $header;
        return $this;
    }

    public function column(ColumnBuilder $column): static
    {
        $this->columns[$column->name] = $column;
        return $this;
    }

    public function del(): static
    {
        $this->columns['del'] = ColumnBuilder::build('del')
            ->classHeader('head del')
            ->headerIcon(Icon::trashIcon())
            ->class('cell del')
            ->callback(fn() => Icon::trashIcon())
            ->emptyRow(fn() => Icon::trashIcon())
            ->width('50px')
            ->get();
        return $this;
    }

    public function edit(): static
    {
        $this->columns['edit'] = ColumnBuilder::build('edit')
            ->classHeader('head edit')
            ->class('cell edit')
            ->callback(fn() => Icon::edit())
            ->width('50px')
            ->get();

        return $this;
    }

    public function addButton(): static
    {
        $this->addButton   = true;
        return $this;
    }

    protected function prepareGridHeader(): void
    {
        $columns = '';
        foreach ($this->columns as $column) {
            $columns .= ' ' . $column->width;
        }
        $this->grid .= "style='display: grid; grid-template-columns:{$columns}'";
    }

    public function get(): array
    {
        $this->prepareGridHeader();
        $this->items = $this->take ? $this->items->take($this->take) : $this->items;
        return get_object_vars($this);
    }
}