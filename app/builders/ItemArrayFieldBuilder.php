<?php

namespace app\builders;

use app\view\components\Builders\Builder;
use Illuminate\Database\Eloquent\Model;

class ItemArrayFieldBuilder extends Builder
{
    private string $field;
    private array $item;
    private string $dataField;
    private string $class;
    private string $name;
    private string $html;
    private string $value;
    private string $dataModel;
    private string $hidden;
    private string $link;
    private string $required;
    private string $contenteditable;

    public function __construct()
    {
        parent::__construct();
    }

    public static function build(string $fieldName, Model $item)
    {
        $field                  = new static();
        $field->field           = $fieldName;
        $field->dataField       = '';
        $field->contenteditable = '';
        $field->hidden          = '';
        $field->required        = '';
//        $field->html            = '';
//        $field->value           = '';
//        $field->name            = '';
        $field->item            = $item->toArray();
        return $field;
    }

    public function class(string $class)
    {
        $this->class = $class;
        return $this;
    }

    public function name(string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function link(string $link)
    {
        $this->link = $link;
        return $this;
    }

    public function html(string $html)
    {
        $this->html = $html;
        return $this;
    }

    public function required()
    {
        $this->required = 'required';
        return $this;
    }

    public function hidden()
    {
        $this->hidden = 'hidden';
        return $this;
    }

    public function contenteditable()
    {
        $this->contenteditable = 'contenteditable';
        return $this;
    }

    public function toHtml(string $model): string
    {
        $this->dataModel = "data-model={$model}";
        $field           = $this;
        ob_start();
        include __DIR__ . '/row.php';
        return ob_get_clean();
    }

    public function get()
    {
        $this->name  = $this->name ?? $this->field;
        $this->value = $this->html ?? $this->item[$this->field];
        return $this;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field ?? '';
    }

    /**
     * @return array
     */
    public function getItem(): array
    {
        return $this->item;
    }

    /**
     * @return string
     */
    public function getDatafield(): string
    {
        return $this->dataField ? "data-field={$this->dataField}" : '';
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->html;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getDataModel(): string
    {
        return $this->dataModel;
    }

    /**
     * @return string
     */
    public function getHidden(): string
    {
        return $this->hidden ?? '';
    }

    /**
     * @return string
     */
    public function getRequired(): string
    {
        return $this->required;
    }

    /**
     * @return mixed
     */
    public function getContenteditable()
    {
        return $this->contenteditable;
    }


}