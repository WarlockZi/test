<?php


namespace app\view\components\Builders\ItemBuilder;


use app\blade\View;
use app\blade\views\admin\product\DndBuilder;
use app\view\components\Builders\CheckboxBuilder\CheckboxBuilder;
use Illuminate\Database\Eloquent\Model;

class ItemFieldBuilder
{
    public string $field;
    public Model $item;

    public string $dataAttributes = '';
    public string $name;
    public string $value;

    public string $html;
    public DndBuilder $dnd;

    public string $class = '';
    public string $hidden = '';
    public string $required = '';
    public string $contenteditable = '';
    public string $tooltip = '';

    public static function build(string $fieldName, ?Model $item): static
    {
        $field        = new static();
        $field->field = $fieldName;
        $field->item  = $item;
        return $field;
    }

    public function class(string $class): static
    {
        $this->class = $class;
        return $this;
    }

    public function name(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function tooltip(string $tooltip): static
    {
        $this->tooltip = $tooltip;
        return $this;
    }

    public function dnd(DndBuilder $dnd): static
    {
        $this->dnd = $dnd;
        return $this;
    }

    public function checkbox(bool $checked, array $data = []): static
    {
        $this->html = CheckboxBuilder::build()
            ->checked($checked)
            ->data($data)
            ->get()->toHtml();
        return $this;
    }


    public function html(string $html): static
    {
        $this->html = $html;
        return $this;
    }

    public function required(): static
    {
        $this->required = 'required';
        return $this;
    }

    public function hidden(): static
    {
        $this->hidden = 'hidden';
        return $this;
    }

    public function contenteditable(): static
    {
        $this->contenteditable = 'contenteditable';
        return $this;
    }

    public function get(): static
    {
        $this->value = $this->html
            ?? $this->item[$this->field]
            ?? '';

        return $this;
    }

    public function data(array $dataAttributes): self
    {
        foreach ($dataAttributes as $key => $value) {
            $this->dataAttributes .= "data-$key='$value'";
        }
        return $this;
    }


    public function toHtml(): string
    {
        $row = APP->get(View::class)->render('admin.components.catalogItem.row',
            ['field' => $this]);
        return $row;
    }
}