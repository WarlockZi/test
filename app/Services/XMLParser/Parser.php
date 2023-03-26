<?php

namespace app\Services\XMLParser;

use app\core\FS;
use app\model\Category;
use app\Services\Slug;

class Parser
{
  protected $file;
  protected $xml;
  protected $xmlObj;

  public function __construct(string $file='g')
  {
    $this->file = FS::platformSlashes(ROOT . '/app/Services/XMLParser/' . $file . '.xml');
    $this->xml = simplexml_load_file($this->file);
    $this->xmlObj = json_decode(json_encode($this->xml), true);
  }

  public function loadCategories(){
    new LoadCategories($this->file);
  }

  public function loadProducts(){
    new LoadProducts($this->file);
  }

  protected function ech(array $item)
  {
    $cat_id = $item['category_id']??0;
    echo "{$item['id']} {$item['pref']} {$item['name']}<br>";
  }

  protected function fillItem(array $group, int $level, int $id, &$parent)
  {
    $item['id'] = $id;
    $item['1s'] = $group['Ид'];
    if ($level > 0)
      $item['category_id'] = $parent['id'];
    $item['name'] = $group['Наименование'];
    $item['slug'] = Slug::slug($item['name']);
    $category = Category::create($item);
    $item['pref'] = str_repeat('-', $level);
    $this->ech($item);

    return $item;
  }

  protected function isAssoc(array $arr)
  {
    if (array() === $arr) return false;
    return array_keys($arr) !== range(0, count($arr) - 1);
  }
}