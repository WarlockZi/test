<?php


namespace app\view\components\Builders\CheckboxBuilder;


use app\service\Fs\FS;

class CheckboxBuilder
{
    public string $field = '';
    public string $pivot = '';
    public string $checked = '';
    public string $data = '';
    public string $class = '';
    public string $id = '';
    public string $for = '';
    public string $label = '';
    public string $labelClass = '';


    public static function build(): CheckboxBuilder
    {
        return new self();
    }

    public function pivot(string $field): static
    {
        $this->pivot = "data-pivot=$field";
        return $this;
    }

    public function field(string $field): static
    {
        $this->field = "data-field=$field";
        return $this;
    }

    public function checked($checked = true): static
    {
        $this->checked = $checked ? "checked" : "";
        return $this;
    }

    public function data(string $postfix, string|null $value): static
    {
        $this->data .= $this->data . "data-$postfix=$value ";
        return $this;
    }

    public function class(string $class): static
    {
        $this->class = "class ='$class'";
        return $this;
    }

    public function label(string $class, string $label): static
    {
        $this->labelClass = "class ='{$class}'";
        $this->label      = $label;

        $this->for = $this->field;
        $this->id  = $this->field;

        return $this;
    }

    public function get(): self
    {
        return $this;
//        $vars = get_object_vars($this);
//        return $vars;
//        return get_object_vars($this);
//        $box = get_object_vars($this);
//        if ($this->label) {
//            return FS::getFileContent(ROOT . '/app/view/components/Builders/CheckboxBuilder/labelCheckboxTemplate.php', compact('box'));
//        } else {
//            return FS::getFileContent(ROOT . '/app/view/components/Builders/CheckboxBuilder/checkboxTemplate.php', compact('box'));
//        }
    }

}