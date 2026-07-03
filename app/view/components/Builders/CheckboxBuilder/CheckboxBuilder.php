<?php


namespace app\view\components\Builders\CheckboxBuilder;


use app\blade\View;

class CheckboxBuilder
{
    public string $checked = '';
    public string $dataAttributes = '';
    public string $class = '';


    public string $label = '';
    public string $labelClass = '';
    public string $id = '';
    public string $for = '';

    public static function build(): CheckboxBuilder
    {
        return new self();
    }
    public function data(array $dataAttributes): self
    {
        foreach ($dataAttributes as $key => $value) {
            $this->dataAttributes .= "data-$key='$value'";
        }
        return $this;
    }

    public function checked(?string $field): static
    {
        $this->checked = (bool)$field?"checked":'';
        return $this;
    }

    public function class(string $class): static
    {
        $this->class = "class ='$class'";
        return $this;
    }

    public function label(string $label, string $for, string $labelClass='',): static
    {
        $this->labelClass = "class ='{$labelClass}'";
        $this->label      = $label;

        $this->for = $for;
        $this->id  = $for;

        return $this;
    }

    public function get(): self
    {
        return $this;
    }
    public function toHtml(): string
    {
        $view  =  APP->get(View::class);
        $html = $view->render('admin.components.checkbox.checkbox', ['checkbox'=>$this]);
//        $this->emptyRow = $html;
        return $html;
    }

}