<?php


namespace app\view\components\Builders\TableBuilder;


use app\core\FS;
use app\core\Icon;
use app\view\components\Traits\CleanString;
use Illuminate\Database\Eloquent\Collection;

class Table
{
    use CleanString;

    private string $pageTitle = '';
    private string $header = '';
    private string $grid = '';
    private array $columns = [];
    private string $class = '';
    private int $take = 0;
    private bool $headEditCol = false;
    private bool $headDelCol = false;
    private string $emptyRow = '';
    private string $add = '';
    private string $dataRelation = '';
    private string $dataRelationType = '';
    private string $dataModel = '';
    private string $html = '';
    private string $addButton = '';
    private Collection|null $items;

    private FS $fs;

    public static function build(Collection|null $items): self
    {
        $list        = new static();
        $list->items = $items;
        $list->fs    = new FS(__DIR__);

        return $list;
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

    public function relation(string $relation, string $relationType): static
    {
        $this->dataRelation      = "data-relation='$relation'";
        $this->dataRelationType = "data-relationType='$relationType'";
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

    public function header(string $header): static
    {
        $this->header = $header;
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
//        if ($this->headDelCol) {
        $hidden    = $itemId ? '' : 'hidden';
        $trashIcon = Icon::trashIcon();
        $str       = "<div {$hidden} class='del cell' $this->dataModel " .
            "data-id='{$itemId}'>$trashIcon</div>";
        return $str;
//        }
//        return '';
    }

    protected function emptyRow(): string
    {
        if (!$this->addButton) return '';
        $str = '';
        foreach ($this->columns as $field => $column) {
            if ($field==='del') continue;

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
        $this->columns['del'] = ColumnBuilder::build()
            ->classHeader('head del')
            ->class('cell del')
            ->callback(fn() => Icon::trashIcon())
            ->width('50px')
            ->get();
        return $this;
    }

    public function edit(): static
    {
        $this->columns['edit'] = ColumnBuilder::build()
            ->classHeader('head edit')
            ->class('cell edit')
            ->callback(fn() => Icon::edit())
            ->width('50px')
            ->get();

        return $this;
    }

    public function addButton(string $pivot = ''): static
    {
        $this->addButton = $pivot;
        $this->add       = $this->fs->getContent('add', ['addButton' => $this->addButton]);
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

    protected function getEmpty($column)
    {
        if ($column->emptyRow) {
            if (is_callable($column->emptyRow)) {
                return call_user_func($column->emptyRow);
            }
            return $column->emptyRow;
        }
        return '';
    }

    public function get(): string
    {
        try {
            $this->emptyRow = $this->emptyRow();
            $this->prepareGridHeader();
            $this->items = $this->take ? $this->items->take($this->take) : $this->items;
            $data        = get_object_vars($this);
            $content     = $this->fs->getContent('tableTemplate', $data);
            return $this->clean($content);

        } catch (\Throwable $error) {
            return $error->getMessage();
        }
    }
}