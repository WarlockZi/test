<?php


namespace app\builders;

use app\core\FS;
use app\view\components\Builders\Builder;
use Illuminate\Database\Eloquent\Model;

class ItemArrayBuilder extends Builder
{
    private string $toListText;
    private string $toListHref;
    private string $pageTitle;
    private string $class;
    private array $item;
    private array $fields;
    private array $tabs;
    private string $id;
    private string $del;
    private string $softDel;
    private string $save;
    private string $toList;
    private string $html;
    private string $modelName;
    private string $dataId;
    private string $dataModel;
    private string $pageTiltle;
    private FS $fs;

    public function __construct()
    {
        parent::__construct();
        $this->fs     = new FS(__DIR__);
        $this->dataId = '';
        $this->html = '';
    }

    public static function build(Model $item, string $modelName)
    {
        $view            = new static();
        $view->modelName = $modelName;
        $view->item      = $item->toArray();
        return $view;
    }

    public function class(string $class)
    {
        $this->class = $class;
        return $this;
    }

    public function pageTitle(string $pageTitle)
    {
        $this->pageTitle = $pageTitle;
        return $this;
    }

    public function field(ItemArrayFieldBuilder $field)
    {
        $this->fields[] = $field;
        return $this;
    }

    public function tab($tab)
    {
        $this->tabs[] = $tab;
        return $this;
    }

    public function del(bool $isAdmin = true)
    {
        if ($isAdmin) {
            $this->del = true;
        }
        return $this;
    }

    public function save()
    {
        $this->save = true;
        return $this;
    }

    public function toList(string $href = '', string $text = '', bool $isAdmin = true)
    {
        if ($isAdmin) {
            $this->toList = true;
            if ($href) {
                $this->toListHref = '/' . $href;
            }
            $this->toListText = $text ? $text : $this->toListText;
        }
        return $this;
    }

    public function softDel()
    {
        $this->del     = false;
        $this->softDel = true;
        return $this;
    }

    public function get()
    {
        try {
//            $this->itemB='';
            $data = get_object_vars($this);
            return $this->clean($this->fs->getContent('ItemTemplate', $data));

        } catch (\Exception $exception) {
            return $exception->getMessage();
        } catch (\Error $exception) {
            return $exception->getMessage();

        }
    }

    ///  GETTERS
    public function getToListText(): string
    {
        return $this->toListText ?? 'К списку';
    }

    public function getToListHref(): string
    {
        return $this->toListHref ?? '';
    }

    public function getClass(): string
    {
        return $this->class ?? '';
    }

    public function getItem()
    {
        return $this->item ?? [];
    }

//    public function getId()
//    {
//        return $this->id ?? 0;
//    }

    public function getHtml(): string
    {
        return $this->html;
    }

    public function getModelName(): string
    {
        return $this->modelName ?? '';
    }

    public function getTabs(): array
    {
        return $this->tabs ?? [];
    }

    public function getFields(): array
    {
        return $this->fields ?? [];
    }

    public function getField(): string
    {
        return $this->fields;
    }


    public function getSoftDel()
    {
        return $this->softDel;
    }

//    public function sid(Product $product)
//    {
//        $this->sid = "data-sid='{$product['1s_id']}'";
//        return $this;
//    }


//    function getModelName($table)
//    {
//        return Str::studly(Str::singular($table));
//    }

}