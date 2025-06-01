<?php

namespace app\blade\views\admin\report\productFilter;


class FilterView
{

    public string $id;
    public array $checked;
    public string|null $name;
    public string $filterName;
    public array $toFilter;
    public array $toSave;
    public string $title;
    public array|string $options;
    public string $emtyOption;
    public array $filters;

    public function __construct()
    {

    }

    public function title(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function filterName(string $filterName): self
    {
        $this->name       = "name='{$filterName}'";
        $this->filterName = $filterName;
        return $this;
    }

    public function checked(array $checked): self
    {
        $this->checked = $checked;
        return $this;
    }

    public function toFilter(array $toFilter): self
    {
        $this->toFilter = $toFilter;
        return $this;
    }

    public function toSave(array $toSave): self
    {
        $this->toSave = $toSave;
        return $this;
    }


    public function options(array|string $options): self
    {
        $this->options = $options;
        return $this;
    }

    public function emptyOption(): static
    {
        $this->emtyOption = "<option value=''></option>";
        return $this;
    }

    public function get(): self
    {
        return $this;
    }

}
