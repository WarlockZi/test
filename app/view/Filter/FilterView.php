<?php

namespace app\view\Filter;

use app\core\FS;

class FilterView
{
    private FS $fs;
    private string $id;
    private string $name;
    private string $filterName;
    private array $userFilters;
    private string $title;
    private bool $checkboxSave;
    private string $checkboxName;
    private string $checkboxChecked;
    private array|string $options;
    private string $emtyOption;
    public function __construct()
    {
        $this->fs = new FS(__DIR__);
    }

    public function title(string $title): FilterView
    {
        $this->title = $title;
        return $this;
    }
    public function filterName(string $filterName): FilterView
    {
        $this->filterName = $filterName;
        return $this;
    }
    public function userFilters(array $userFilters): FilterView
    {
        $this->userFilters = $userFilters;
        return $this;
    }
    public function selectName(string $name): FilterView
    {
        $this->name = "name='{$name}'";
        return $this;
    }
    public function checkboxSave(string $name, bool $checked = false): FilterView
    {
        $this->checkboxSave = true;
        $this->checkboxChecked = $checked ? 'checked' : '';
        $this->checkboxName = $name;
        return $this;
    }
    public function options(array|string $options): FilterView
    {
        $this->options = $options;
        return $this;
    }
    public function emptyOption()
    {
        $this->emtyOption = "<option value=''></option>";
        return $this;
    }
    public function get()
    {
        $args = get_object_vars($this);
        return $this->fs->getContent('filter', $args);
    }
    public function getProductFilter(string $filters)
    {
        return $this->fs->getContent('productFilter', compact('filters'));
    }

}