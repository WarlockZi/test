<?php

namespace app\Services\XMLParser;

use app\core\FS;

class Parser
{
  protected $file;
  protected $xml;
  protected $xmlObj;

  public function __construct(string $file)
  {
    $this->file = FS::platformSlashes(ROOT . '/app/Services/XMLParser/' . $file . '.xml');
    $this->xml = simplexml_load_file($this->file);
    $this->xmlObj = json_decode(json_encode($this->xml), true);
    $this->run();
  }

  protected function ech(array $item)
  {
    echo "{$item['id']} {$item['pref']} {$item['name']}<br>";
  }

  protected function hasChildren(array $group)
  {
    return isset($group['Группы']);
  }

  protected function fillItem(array $group, int $level, int $id)
  {
    $item['id'] = $id;
    $item['1s'] = $group['Ид'];
    $item['name'] = $group['Наименование'];
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