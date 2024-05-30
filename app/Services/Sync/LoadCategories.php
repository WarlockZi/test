<?php

namespace app\Services\Sync;


use app\model\Category;
use app\Services\Slug;

class LoadCategories extends Load
{
   protected $parent = 0;

   public function __construct($file)
   {
      parent::__construct($file, 'category');
      $this->run($this->data);
   }


   protected function run($groups): void
   {
      if ($this->isAssoc($groups)) {
         $item = $this->fillItem($groups);
         if (isset($groups['Группы'])) {
            $this->parent = $item['id'];
            $this->run($groups['Группы']['Группа']);
         }
      } else {
         foreach ($groups as $group) {
            $this->run($group);
         }
         $this->parent = null;
      }
   }

   protected function fillItem(array $group): array
   {
      $item['1s_id']       = $group['Ид'];
      $item['category_id'] = $this->parent;
      $item['show_front']  = (int)!(!!$this->parent);

      $item['name']       = $group['Наименование'];
      $item['slug']       = Slug::slug($item['name']);
      $item['deleted_at'] = NULL;

      return Category::withTrashed()
         ->updateOrCreate(['1s_id' => $item['1s_id']], $item)->toArray();

   }

   protected function ech(array $item): void
   {
      echo "{$item['id']} {$item['pref']} {$item['name']}<br>";
   }

   protected function isAssoc(array $arr): bool
   {
      if (array() === $arr) return false;
      return array_keys($arr) !== range(0, count($arr) - 1);
   }

}