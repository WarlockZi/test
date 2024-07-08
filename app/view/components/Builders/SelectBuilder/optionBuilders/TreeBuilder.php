<?php


namespace app\view\components\Builders\SelectBuilder\optionBuilders;


use app\core\Error;
use Illuminate\Database\Eloquent\Collection;

abstract class TreeBuilder
{
    protected Collection $items;
    protected string $relation;
    protected int $multiply;
    protected string $tab;
    protected array $arr;

    protected $selected = null;
    protected $excluded = null;
    protected $localtab;

    protected $initialOption;
    protected array $flatArray = [];

    public function __construct(Collection $collection, string $relation, int $multiply = 1, string $tab = '&nbsp;')
    {
        $this->arr      = $collection->toArray();
        $this->items    = $collection;
        $this->relation = $relation;
        $this->multiply = $multiply;
        $this->tab      = $tab;
        $this->validateFormat();
        return $this;
    }

    public function get(): string
    {
        $str = $this->initialOption;
        $str .= $this->options($this->arr, 0, '');
        return $str;
    }
    public function selected(?int $selected)
    {
        $this->selected = $selected;
        return $this;
    }

    public function excluded($excluded)
    {
        $this->excluded = $excluded;
        return $this;
    }

    protected function validateFormat()
    {
        $first = $this->arr[0];
        if (!isset($first['id']) || !isset($first['name'])) Error::setError('no name or id');
        if (!isset($first[$this->relation])) Error::setError('no relation');
    }


}