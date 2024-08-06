<?php


namespace app\view\components\Builders\ItemBuilder;

use app\model\Product;
use app\view\components\Traits\CleanString;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ItemBuilder
{
    use CleanString;
    private string $model;
    private string $dataModel;
    private string $id;
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

    public string $html = '';

    public static function build(?Model $item, string $model):ItemBuilder
    {
        $view            = new static();
        $name            = $view->getModelName($item->getTable());
        $view->dataModel = "data-model='{$model}'";
        $view->model     = $model;
        $view->item      = $item->toArray();
        $view->id        = "data-id='{$view->item['id']}'";
        return $view;
    }

    public function class(string $class): ItemBuilder
    {
        $this->class = $class;
        return $this;
    }

    public function pageTitle(string $pageTitle): ItemBuilder
    {
        $this->pageTitle = $pageTitle ? "<div class='page-title'>$pageTitle</div>" : '';
        return $this;
    }

    public function field(ItemFieldBuilder $field): ItemBuilder
    {
        $this->fields[] = $field;
        return $this;
    }

    public function tab($tab): ItemBuilder
    {
        $this->tabs[] = $tab;
        return $this;
    }

    public function get(): string
    {
        ob_start();
        include ROOT . '/app/view/components/Builders/ItemBuilder/ItemTemplate.php';
        $result = ob_get_clean();
        return $this->clean($result);
    }

    function getModelName($table): string
    {
        return Str::studly(Str::singular($table));
    }

    public function del(bool $isAdmin = true): ItemBuilder
    {
        if ($isAdmin) {
            $this->del = true;
        }
        return $this;
    }

    public function sid(Product $product): ItemBuilder
    {
        $this->sid = "data-sid='{$product['1s_id']}'";
        return $this;
    }

    public function softDel(): ItemBuilder
    {
        $this->del     = false;
        $this->softDel = true;
        return $this;
    }

    public function save(): ItemBuilder
    {
        $this->save = true;
        return $this;
    }

    public function toList(string $href = '', string $text = '', bool $isAdmin = true): ItemBuilder
    {
        if ($isAdmin) {
            $this->toList = true;
            if ($href) {
                $this->toListHref = '/' . $href;
            }
            $this->toListText = $text ?? $this->toListText;
        }
        return $this;
    }

}