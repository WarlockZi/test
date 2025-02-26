<?php


namespace app\view\components\Builders\ItemBuilder;


use Illuminate\Database\Eloquent\Model;

class ItemFieldBuilder
{
    public string $field;
    public Model $item;

    public string $relation='';
    public string $name;
    public string $id;

    public string $html;
//    public string $dataModel;
    public string $link;

    public string|null $value;
    public string $class = '';
    public bool $hidden = false;
    public bool $required = false;
    public string $contenteditable = '';

    public static function build(string $fieldName, Model|null $item):static
    {
        $field            = new static();
        $field->field     = $fieldName;
        $field->item      = $item;
        return $field;
    }

    public function class(string $class):static
    {
        $this->class = $class;
        return $this;
    }

    public function name(string $name):static
    {
        $this->name = $name;
        return $this;
    }
    public function id($id):static
    {
        $this->id = "id='$id'";
        return $this;
    }
    public function link(string $link):static
    {
        $this->link = $link;
        return $this;
    }
    public function relation(string $relation):static
    {
        $this->relation = $relation;
        return $this;
    }
    public function getDatarelation(): string
    {
        return "data-relation='$this->relation'";
    }
    public function html(string $html):static
    {
        $this->html = $html;
        return $this;
    }

    public function required():static
    {
        $this->required = 'required';
        return $this;
    }

    public function hidden():static
    {
        $this->hidden = 'hidden';
        return $this;
    }

    public function contenteditable():static
    {
        $this->contenteditable = 'contenteditable';
        return $this;
    }

    public function get():static
    {
        $this->name  = $this->name ?? $this->field;
        $this->value = $this->html ?? $this->item[$this->field];

        return $this;
    }
    public function getDatafield(): string
    {
        return "data-field='$this->field'";
    }

    public function toHtml(string $model): string
    {
        $field           = $this;
        ob_start();
        include ROOT . '/app/view/components/Builders/ItemBuilder/row.php';
        return ob_get_clean();
    }

}