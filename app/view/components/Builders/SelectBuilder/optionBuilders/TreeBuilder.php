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

    public function __construct(Collection $items, string $relation, int $multiply = 1, string $tab = '&nbsp;')
    {
        $this->items      = $items;
        $this->arr      = $items->toArray();
        $this->relation = $relation;
        $this->multiply = $multiply;
        $this->tab      = $tab;
        $this->validateFormat();
        return $this;
    }


    public function selected(?int $selected):self
    {
        $this->selected = $selected;
        return $this;
    }

    public function excluded($excluded):self
    {
        $this->excluded = $excluded;
        return $this;
    }

    protected function validateFormat():void
    {
        $first = $this->arr[0];
        if (!isset($first['id']) || !isset($first['name'])) Error::setError('no name or id');
        if (!isset($first[$this->relation])) Error::setError('no relation');
    }
    public function get(): string
    {
        $str = $this->initialOption;
        $str .= $this->options($this->arr, 0, '');
        return $str;
    }


}