<?php

namespace app\builders;

use app\core\FS;
use app\view\components\Builders\Builder;
use Illuminate\Database\Eloquent\Model;

class ItemArrayFieldBuilder extends Builder
{
    private string $fieldName;
    private ItemArrayFieldBuilder $field;
    private array $item;
    private string $class;
    private string $name;
    private string $html;
    private string $value;
    private string $dataModel;
    private string $dataField;
    private string $hidden;
    private string $link;
    private string $required;
    private bool $del;
    private bool $softDel;
    private bool $edit;
    private bool $save;
    private bool $toList;
    private string $contenteditable;
    private FS $fs;
    private ItemArrayFieldBuilder $fieldObj;

    public function __construct()
    {
        parent::__construct();
    }

    public static function build(string $fieldName, Model $item)
    {
        $field                  = new static();
        $field->fieldName       = $fieldName;
        $field->fs              = new FS(__DIR__);
        $field->dataField       = '';
        $field->contenteditable = '';
        $field->hidden          = '';
        $field->required        = '';
        $field->html            = '';
        $field->del             = false;
        $field->softDel         = false;
        $field->edit            = false;
        $field->save            = false;
        $field->toList          = false;
        $field->fieldObj        = $field;
//        $field->name            = '';
        $field->item = $item->toArray();
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
        $this->field     = $this;

        $data = get_object_vars($this);
        return $this->fs->getContent('row', $data);
    }
    public function dataField(string $dataField): ItemArrayFieldBuilder
    {
        $this->dataField = "data-field='{$dataField}'";
        return $this;
    }

    public function get()
    {
        $this->name  = $this->name ?? $this->fieldName;
        $this->value = $this->html ?? $this->item[$this->fieldName];
        return $this;
    }

    public function getField(): string
    {
        return $this->field ?? '';
    }

    public function getItem(): array
    {
        return $this->item;
    }

    public function getDatafield(): string
    {
        return array_key_exists($this->fieldName, $this->item) ? "data-field={$this->fieldName}" : $this->dataField;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHtml(): string
    {
        return $this->html;
    }

    public function getValue()
    {
        return !!$this->html ?$this->html: $this->item[$this->fieldName];
    }

    public function getDataModel(): string
    {
        return $this->dataModel;
    }

    public function getHidden(): string
    {
        return $this->hidden;
    }

    public function getRequired(): string
    {
        return $this->required;
    }

    public function isDel(): string
    {
        return $this->del;
    }

    public function isEdit(): string
    {
        return $this->edit;
    }

    public function isSoftDel(): bool
    {
        return $this->softDel;
    }

    public function isSave(): bool
    {
        return $this->save;
    }

    public function isToList(): bool
    {
        return $this->toList;
    }

    public function getContenteditable()
    {
        return $this->contenteditable;
    }


}