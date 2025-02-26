<?php

namespace app\view\Filter;

use app\core\FS;

class FilterView
{
    private FS $fs;
    private string $id;
    private array $checked;
    private string|null $name;
    private string $filterName;
    private array $toFilter;
    private array $toSave;
    private string $title;
    private bool $checkboxSave;
    private string|null $checkboxName;
    private string $checkboxChecked;
    private array|string $options;
    private string $emtyOption;

    public function __construct()
    {
        $this->fs = new FS(__DIR__);
    }

    public function title(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function filterName(string $filterName): self
    {
        $this->name = "name='{$filterName}'";
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
//    public function selectName(string $name): FilterView
//    {
//        $this->name = "name='{$name}'";
//        return $this;
//    }

    public function checkboxSave(string|null $name, bool $checked = false): FilterView
    {
        $this->checkboxSave    = true;
        $this->checkboxChecked = $checked ? 'checked' : '';
        $this->checkboxName    = $name;
        return $this;
    }

    public function options(array|string $options): FilterView
    {
        $this->options = $options;
        return $this;
    }

    public function emptyOption(): static
    {
        $this->emtyOption = "<option value=''></option>";
        return $this;
    }

    public function get(): string
    {
        $args = get_object_vars($this);
        return $this->fs->getContent('filter', $args);
    }

    public function getProductFilterPanel(string $filters)
    {
        return $this->fs->getContent('productFilter', compact('filters'));
    }

}