<?php


namespace app\view\components\Builders\ItemBuilder;


use Illuminate\Database\Eloquent\Model;

class ItemFieldBuilder
{
    public string $field;
    public Model $item;
    public string $datafield;
    public string $name;

    public string $html;
    public string $dataModel;
    public string $link;

    public string|null $value;
    public string $class = '';
    public bool $hidden = false;
    public bool $required = false;
    public string $contenteditable = '';

    public static function build(string $fieldName, Model $item): ItemFieldBuilder
    {
        $field            = new static();
        $field->datafield = "data-field=$fieldName";
        $field->field     = $fieldName;
        $field->item      = $item;
        return $field;
    }

    public function class(string $class): ItemFieldBuilder
    {
        $this->class = $class;
        return $this;
    }

    public function name(string $name): ItemFieldBuilder
    {
        $this->name = $name;
        return $this;
    }

    public function link(string $link): ItemFieldBuilder
    {
        $this->link = $link;
        return $this;
    }

    public function html(string $html): ItemFieldBuilder
    {
        $this->html = $html;
        return $this;
    }

    public function required(): ItemFieldBuilder
    {
        $this->required = 'required';
        return $this;
    }

    public function hidden(): ItemFieldBuilder
    {
        $this->hidden = 'hidden';
        return $this;
    }

    public function contenteditable(): ItemFieldBuilder
    {
        $this->contenteditable = 'contenteditable';
        return $this;
    }

    public function get(): ItemFieldBuilder
    {
        $this->name  = $this->name ?? $this->field;
        $this->value = $this->html ?? $this->item[$this->field];

        return $this;
    }


    public function toHtml(string $model): string
    {
        $this->dataModel = "data-model=$model";
        $field           = $this;
        ob_start();
        include ROOT . '/app/view/components/Builders/ItemBuilder/row.php';
        return ob_get_clean();
    }

}