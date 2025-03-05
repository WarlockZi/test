<?php


namespace app\view\components\Builders\SelectBuilder\optionBuilders;

//use Illuminate\Database\Eloquent\Collection;

use Illuminate\Support\Collection;

class ArrayOptionsBuilder
{
    private array $arr;
    protected null|int|string $selected = 0;
    protected array $excluded = [];
    protected string $initialOption = '';
    protected array $fieldsMap;
    protected string $field = 'name';
//    protected array $items = [];

    public static function build(array|Collection $array, array $fieldsMap = []): ArrayOptionsBuilder
    {
        $arrayOptions            = new self();
        $arrayOptions->arr       = is_array($array)? $array: $array->toArray();
        $arrayOptions->fieldsMap = $fieldsMap;
        return $arrayOptions;
    }


    public function get(): string
    {
        if (!count($this->arr) && !$this->initialOption) $this->initialOption();
        $str = $this->initialOption;
        $str .= $this->options('');
        return $str;
    }

    public function field(string $field): ArrayOptionsBuilder
    {
        $this->field = $field;
        return $this;
    }

    public function options(string $string = ''): string
    {
        foreach ($this->arr as $item) {
            $id = $item['id'];
            if (in_array($id, $this->excluded)) continue;
            $selected = ($id == $this->selected) ? "selected" : '';
            $string   .= "<option value = $id $selected>{$item[$this->field]}</option>";
        }
        return $string;
    }

    public function selected(null|int|string $selected): ArrayOptionsBuilder
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