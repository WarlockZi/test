<?php


namespace app\view\components\Builders\SelectBuilder\optionBuilders;


use app\Exceptions\Router\RouterError;
use Illuminate\Database\Eloquent\Collection;

abstract class TreeBuilder
{
    protected Collection $items;
    protected string $relation;
    protected int $multiply;
    protected string $tab;
    protected array $arr;

    protected int|string|null $selected = null;
    protected string $selectedField;

    protected $excluded = null;
    protected $localtab;

    protected $initialOption;

    public function __construct(Collection $items, string $relation, int $multiply = 1, string $tab = '&nbsp;')
    {
        $this->items    = $items;
        $this->arr      = $items->toArray();
        $this->relation = $relation;
        $this->multiply = $multiply;
        $this->tab      = $tab;
        $this->validateFormat();
        return $this;
    }


    public function selected(int|string $selected, string $field = 'id'): self
    {
        $this->selected      = $selected;
        $this->selectedField = $field;
        return $this;
    }

    public function selectedByField(array $selected): self
    {
        $key                 = array_keys($selected)[0];
        $this->selectedField = $key;
        $this->selectedValue = $selected[$key];
        return $this;
    }

    public function excluded($excluded): self
    {
        $this->excluded = $excluded;
        return $this;
    }

    protected function validateFormat(): void
    {
        try {
            $first = @$this->arr[0];
            if (!isset($first['id']) || !isset($first['name'])) RouterError::setError('no name or id');
            if (!isset($first[$this->relation])) RouterError::setError('no relation');
        } catch (\Throwable $exception) {
            $exception->getMessage();
        }
    }

    public function get(): string
    {
        $str = $this->initialOption;
        $str .= $this->options($this->arr, 0, '');
        return $str;
    }


}