<?php

namespace app\Services\Sync;


use app\model\Category;
use app\model\Product;
use app\Services\Slug;

class LoadProducts extends Load
{

   protected $logger;

   public function __construct($file)
   {
      parent::__construct($file, 'product');
      $this->run();
   }

   protected function run(): void
   {
      $id = 0;
      foreach ($this->data as $good) {
         $id++;
         $product                = $this->fillGood($good, $id);
         $cat                    = Category::where('1s_id', $product['1s_category_id'])->first();
         $product['category_id'] = $cat->id;
         $product['deleted_at']  = null;
         $updated                = Product::withTrashed()
            ->updateOrCreate(['1s_id' => $product['1s_id']], $product);
         $f                      = $updated;
      }
   }

   protected function fillGood($good, $id): array
   {
      $g['1s_id']          = $good['Ид'];
      $g['1s_category_id'] = $good['Группы']['Ид'];
      $g['art']            = $good['Артикул'] ? trim($good['Артикул']) : '';
      $g['name']           = $good['Наименование'];
      $g['print_name']     = $good['ЗначенияРеквизитов']['ЗначениеРеквизита'][3]['Значение'];
      $g['slug']           = Slug::slug($g['print_name']);
      if (Product::where('slug', $g['slug'])->first()) {
         $g['slug'] = $g['slug'] . '_' . Slug::slug($g['art']);
      }
      $g['txt'] = $good['Описание'] ? preg_replace('/\n/', '<br>', $good['Описание']) : '';

      return $g;
   }

   protected function ech($item, $id, $sameSlug = ''): void
   {
      echo "{$id}  - {$sameSlug} {$item['name']}<br>";
   }
}