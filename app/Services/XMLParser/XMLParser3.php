<?php

namespace app\Services\XMLParser;

use app\core\FS;

class XMLParser3 extends Parser
{
  public function __construct(string $file)
  {
    parent::__construct('d');
  }

  protected function run()
  {
    $groups = $this->xmlObj['Классификатор']['Группы']['Группа'];
    $arr = [];
    $id = 0;
    $this->recursion($groups, $arr, 0,$id, $arr);
    $goods = [''];
  }

  protected function recursion($groups, &$arr, $level = 0, &$id, &$parent=null)
  {
    foreach ($groups as $i => $group) {
      if ($this->isAsscociative($group)) {
        $id++;
        $item = $this->fillItem($group, $level, $id);
        $parent['child'][] = $item;
        $this->recursion($group['Группы'], $arr, ++$level, $id, $item);

      } else {
        $id++;
        $item = $this->fillItem($group, $level, $id);
        $parent['child'][] = $item;
      }
    }
  }

}