<?php


namespace app\view\components\Builders\SelectBuilder\optionBuilders;


use Illuminate\Support\Collection;

class PluckOptionsBuilder
{
    private Collection $collection;
    protected null|int|string $selected = 0;
    protected array $excluded = [];
    protected string $initialOption = '';

    public static function build(Collection $collection): PluckOptionsBuilder
    {
        $arrayOptions             = new self();
        $arrayOptions->collection = $collection;
        return $arrayOptions;
    }


    public function get(): string
    {
        if (!count($this->collection) && !$this->initialOption) $this->initialOption();
        $str = $this->initialOption;
        $str .= $this->options('');
        return $str;
    }

    public function options(string $string = ''): string
    {
        foreach ($this->collection as $id=>$item) {
            if (in_array($id, $this->excluded)) continue;
            $selected = ($id == $this->selected) ? "selected" : '';
            $string   .= "<option value = $id $selected>$item</option>";
        }
        return $string;
    }

    public function selected(null|int|string $selected): PluckOptionsBuilder
    {
        if ($selected) {
            $this->selected = $selected;
        }
        return $this;
    }

    public function excluded($excluded): PluckOptionsBuilder
    {
        if (is_numeric($excluded)) {
            $this->excluded[] = $excluded;
        } else {
            $this->excluded = $excluded;
        }
        return $this;
    }

    public function initialOption(int $value = 0, string $label = null): PluckOptionsBuilder
    {
        $this->initialOption = "<option value=$value>$label</option>";
        return $this;
    }
}