<?php


namespace app\view\components\Builders\SelectBuilder\optionBuilders;

use Illuminate\Database\Eloquent\Collection;

class ArrayOptionsBuilder
{
    private array $arr;
    protected int $selected = 0;
    protected array $excluded = [];
    protected string $initialOption = '';
    protected array $fieldsMap;
    protected string $field = 'name';

    public static function build(Collection $collection, array $fieldsMap = []): ArrayOptionsBuilder
    {
        $arrayOptions            = new self();
        $arrayOptions->arr       = $collection->toArray();
        $arrayOptions->fieldsMap = $fieldsMap;
        return $arrayOptions;
    }


    public function get(): string
    {
        if (!count($this->arr) && !$this->initialOption) $this->initialOption();
        $str = $this->initialOption;
        $str .= $this->options($this->arr, '');
        return $str;
    }

    public function field(string $field): ArrayOptionsBuilder
    {
        $this->field = $field;
        return $this;
    }

    public function options($items, string $string = ''): string
    {
        foreach ($items as $item) {
            $id = $item['id'];
            if (in_array($id, $this->excluded)) continue;
            $selected = $id == $this->selected ? "selected" : '';
            $string   .= "<option value = $id $selected>{$item[$this->field]}</option>";
        }
        return $string;
    }

    public function selected(int $selected): ArrayOptionsBuilder
    {
        if ($selected) {
            $this->selected = $selected;
        }
        return $this;
    }

    public function excluded($excluded): ArrayOptionsBuilder
    {
        if (is_numeric($excluded)) {
            $this->excluded[] = $excluded;
        } else {
            $this->excluded = $excluded;
        }
        return $this;
    }

    public function initialOption(int $value = 0, string $label = null): ArrayOptionsBuilder
    {
        $this->initialOption = "<option value=$value>$label</option>";
        return $this;
    }
}