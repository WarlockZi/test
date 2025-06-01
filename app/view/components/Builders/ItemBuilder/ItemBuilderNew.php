<?php


namespace app\view\components\Builders\ItemBuilder;

use app\model\Product;
use Illuminate\Database\Eloquent\Model;


class ItemBuilderNew
{
    private string $model;
    private string $sid = '';
    private array $item = [];
    private string $pageTitle;
    private string $class;
    private bool $del = false;
    private bool $softDel = false;
    private bool $save = false;
    public string $toListHref = '';
    public bool $toList = false;
    public string $toListText = 'К списку';
    private array $fields = [];
    private array $tabs = [];


    public static function build(?Model $item, string $model): self
    {
        $view        = new static();
        $view->model = $model;
        $view->item  = $item->toArray();

        return $view;
    }

    public function class(string $class): self
    {
        $this->class = $class;
        return $this;
    }

    public function pageTitle(string $pageTitle): self
    {
        $this->pageTitle = $pageTitle;
        return $this;
    }

    public function field(ItemFieldBuilder $field): self
    {
        $this->fields[] = $field;
        return $this;
    }

    public function tab($tab): self
    {
        $this->tabs[] = $tab;
        return $this;
    }

    public function get(): array
    {
        return $this->toArray();
    }
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function del(bool $isAdmin = true): self
    {
        if ($isAdmin) {
            $this->del = true;
        }
        return $this;
    }

    public function sid(Product $product): self
    {
        $this->sid = "data-sid='{$product['1s_id']}'";
        return $this;
    }

    public function softDel(): self
    {
        $this->del     = false;
        $this->softDel = true;
        return $this;
    }

    public function save(): self
    {
        $this->save = true;
        return $this;
    }

    public function toList(string $href = '', string $text = ''): self
    {
        $this->toList = true;
        if ($href) {
            $this->toListHref = '/' . $href;
        }
        $this->toListText = $text ?? $this->toListText;

        return $this;
    }

}