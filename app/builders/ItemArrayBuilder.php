<?php


namespace app\builders;

use app\core\FS;
use app\view\components\Builders\Builder;
use Illuminate\Database\Eloquent\Model;

class ItemArrayBuilder extends Builder
{
//    private $model;
//    private $sid = '';
    private $fields;
    private $tabs;
    private $toListText;
    private $toListHref;
    private $pageTitle;
    private $class;
    private $item;
    private $dataModel;
    private $id;
    private $del;
    private $softDel;
    private $save;
    private $toList;
    private $html;
    private $modelName;
    private $dataId;

    public function __construct()
    {
        parent::__construct();
        $this->fs = new FS(__DIR__ . DIRECTORY_SEPARATOR);
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
        return $this->clean($this->fs->getContent('ItemTemplate', $this));
    }

    ///  GETTERS
    public function getToListText(): string
    {
        return $this->toListText ?? 'К списку';
    }

    public function getToListHref(): string
    {
        return $this->toListHref??'';
    }

    /**
     * @return mixed
     */
    public function getPageTitle()
    {
        return $this->pageTitle?"<div class='page-title'>{$this->pageTitle}</div>" : '';
    }

    /**
     * @return mixed
     */
    public function getClass():string
    {
        return $this->class??'';
    }

    /**
     * @return mixed
     */
    public function getItem()
    {
        return $this->item??[];
    }

    /**
     * @return mixed
     */
    public function getDataModel()
    {
        return "data-model='{$this->modelName}'";
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id??0;
    }

    public function isDel(): bool
    {
        return $this->del??false;
    }

    public function isSoftDel(): bool
    {
        return $this->softDel??false;
    }

    public function isSave(): bool
    {
        return $this->save??false;
    }

    public function isToList(): bool
    {
        return $this->toList??false;
    }

    public function getHtml(): string
    {
        return $this->html??'';
    }

    /**
     * @return string
     */
    public function getModelName():string
    {
        return $this->modelName??'';
    }

    /**
     * @return string
     */
    public function getDataId():string
    {
        return "data-id='{$this->item['id']}'";
    }

    /**
     * @return array
     */
    public function getTabs():array
    {
        return $this->tabs??[];
    }

    /**
     * @return array
     */
    public function getFields():array
    {
        return $this->fields??[];
    }

    /**
     * @return mixed
     */
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