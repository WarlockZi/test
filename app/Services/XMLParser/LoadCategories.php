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
    $this->recursion($groups, $id, -1, $arr);
    $goods = [''];
  }

  protected function recursion($groups, &$id, $level = 0, &$parent = null)
  {
    $level++;
    foreach ($groups as $i => $group) {
      if ($this->isAssoc($group)) {
        $id++;
        $item = $this->fillItem($group, $level, $id, $parent);
        $parent[] = &$item;
        if (isset($group['Группы']))
          $this->recursion($group['Группы'], $id, $level, $item);
      } else {
        $this->recursion($group, $id, $level, $parent);
      }
    }
  }
}