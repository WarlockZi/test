<?php


namespace app\view\components\Builders\SelectBuilder;


use app\core\Error;
use Illuminate\Database\Eloquent\Collection;

abstract class TreeBuilder
{
    protected array $arr;
    protected string $relation;

    protected $selected = null;
    protected $excluded = null;

    protected $tab;
    protected $localtab;
    protected $tabMultiply;

    protected $initialOption;

    public function __construct(Collection $collection, string $relation, int $multiply = 1, string $tab = '&nbsp;')
    {
        $this->arr = $collection->toArray();
        $this->relation = $relation;
        $this->validateFormat();

        $this->tabMultiply = $multiply;
        $this->tab = $tab;

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