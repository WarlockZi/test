<?php


namespace app\view\components\Builders\ItemBuilder;


use app\model\Image;
use app\Repository\ImageRepository;
use Illuminate\Database\Eloquent\Model;

class ItemFieldBuilder
{

  public $field = '';
  public $item = '';
  public $datafield = '';
  public $class = '';
  public $name = '';
  public $link = '';
  public $type = 'text';
  public $morph = '';
  public $slug = '';
  public $typeModificator = '';
  public $html = '';

  public $value = '';
  public $hidden = '';
  public $required = '';
  public $contenteditable = '';

  public static function build(string $fieldName, Model $item)
  {
    $field = new static();
    $field->datafield = "data-field={$fieldName}";
    $field->field = $fieldName;
    $field->item = $item;
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

  public function type(string $type)
  {
    $this->type = $type;
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

  public function morph($morph)
  {
    $this->morph = $morph;
    return $this;
  }

  public function slug($slug)
  {
    $this->slug = $slug;
    return $this;
  }

  public function get()
  {
    $this->name = $this->name ? $this->name : $this->field;
    $this->setValue();

    return $this;
  }

  protected function setValue(): void
  {
    if ($this->type === 'checkbox') {
      $this->value = '';
      $val = (int)$this->item[$this->field];
      $this->typeModificator = $val === 1 ? 'checked' : '';

    } elseif ($this->type === 'image') {
      $this->value = ImageRepository::getSrc($this);

    } else {
      $this->value = $this->item[$this->field];
    }
  }

  public function toHtml(string $model): string
  {
    $this->dataModel = "data-model={$model}";
    $field = $this;
    ob_start();
    include ROOT . '/app/view/components/Builders/ItemBuilder/row.php';
    return ob_get_clean();

  }


}