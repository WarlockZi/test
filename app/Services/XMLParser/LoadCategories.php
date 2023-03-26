<?php

namespace app\Services\XMLParser;


class LoadCategories extends Parser
{
  public function __construct()
  {
    parent::__construct();
    $this->run();
  }

  protected function run()
  {
    $groups = $this->xmlObj['Классификатор']['Группы']['Группа'];
    $arr = [];
    $id = 0;
    $this->recursion($groups, -1, $id, $arr);
    $goods = [''];
  }

  protected function recursion($groups, $level = 0, &$id, &$parent = null)
  {
    $level++;
    foreach ($groups as $i => $group) {
      if ($this->isAssoc($group)) {
        $id++;
        $item = $this->fillItem($group, $level, $id, $parent);
        $parent[] = &$item;
        if (isset($group['Группы']))
          $this->recursion($group['Группы'], $level, $id, $item);
      } else {
        $this->recursion($group, $level, $id, $parent);
      }
    }
  }
}