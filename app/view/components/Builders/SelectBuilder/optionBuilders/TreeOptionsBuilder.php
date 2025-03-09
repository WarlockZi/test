<?php


namespace app\view\components\Builders\SelectBuilder\optionBuilders;

use Illuminate\Database\Eloquent\Collection;

class TreeOptionsBuilder extends TreeBuilder
{
    public static function build(Collection $collection, string $relation, int $multiply = 1, string $tab = '&nbsp;'): self
    {
        return new self($collection, $relation, $multiply, $tab);
    }

    protected function isExcluded(array $item): bool
    {
        if (is_array($this->excluded)) {
            return in_array($item[$this->selectedField], $this->excluded);
        }
        return $this->excluded === $item[$this->selectedField];
    }

    protected function getOption(array $item, int $level): string
    {
        $id = $item[$this->selectedField];
        if ($this->isExcluded($item)) return '';
        $selected       = ($item[$this->selectedField] == $this->selectedValue) ? 'selected' : '';
        $this->localtab = str_repeat($this->tab, $level * $this->multiply);
        return "<option data-level={$level} value = {$id} {$selected}>{$this->localtab}{$item['name']}</option>";
    }

    public function options(array $items, int $level, string $string): string
    {
        foreach ($items as $item) {
            $string .= $this->getOption($item, $level);
            if (isset($item[$this->relation])) {
                $string .= $this->options($item[$this->relation], $level + 1, '');
            }
        }
        return $string;
    }

    public function initialOption(int $initialOptionValue = 0, string $initialOptionLabel = ''): TreeOptionsBuilder
    {
        $this->initialOption =
            "<option value='{$initialOptionValue}'>{$initialOptionLabel}</option>";
        return $this;
    }
}