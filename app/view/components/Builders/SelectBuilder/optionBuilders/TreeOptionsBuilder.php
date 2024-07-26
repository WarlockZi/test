<?php


namespace app\view\components\Builders\SelectBuilder\optionBuilders;

use Illuminate\Database\Eloquent\Collection;

class TreeOptionsBuilder extends TreeBuilder
{
    public static function build(Collection $collection, string $relation, int $multiply = 1, string $tab = '&nbsp;'): TreeOptionsBuilder
    {
        return new self($collection, $relation, $multiply, $tab);
    }

    public function getFlatNestedArray(int $level = 0, $collection = null): array
    {
        $items = ($collection && $collection->count())
            ? $collection
            : $this->items;

        $arr = $items->toArray();
        $res = $this->flatten($arr);
        return $res;
    }

    protected function flatten(array $array): array
    {
        $arr = array();
        $id  = '';
        array_walk_recursive($array, function ($k, $v) use (&$arr, &$id) {
            if ($v === 'id') {
                $arr[$k] = $k;
                $id      = $k;
            } elseif ($v === 'name') {
                $arr[$id] = $k;
            }
        });
        return $arr;
    }


    protected function isExcluded(int $id)
    {
        if (is_array($this->excluded)) {
            return in_array($id, $this->excluded);
        } elseif (is_numeric($this->excluded)) {
            return $this->excluded === $id;
        }
    }

    protected function getOption($item, $level): string
    {
        $id = $item['id'];
        if ($this->isExcluded($id)) return '';
        $selected       = $id == $this->selected ? 'selected' : '';
        $this->localtab = str_repeat($this->tab, $level * $this->multiply);
        return "<option data-level={$level} value = {$id} {$selected}>{$this->localtab}{$item['name']}</option>";
    }

    public function options($items, $level, $string): string
    {
        foreach ($items as $item) {
//            $this->flatArray[$item['id']] = $item['name'];
            $string .= $this->getOption($item, $level);
            if ($item[$this->relation]) {
                $string .= $this->options($item[$this->relation], $level + 1, '');
            }
        }
        return $string;
    }

    public function initialOption(string $initialOptionLabel = '', int $initialOptionValue = 0): TreeOptionsBuilder
    {
        $this->items->push(['id'=>'0','name'=>'']);
        array_push($this->arr, ['id'=>'0','name'=>'']);
        $this->initialOption =
            "<option value='{$initialOptionValue}'>{$initialOptionLabel}</option>";
        return $this;
    }


}