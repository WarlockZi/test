<?php


namespace app\Repository;

use app\controller\AppController;
use app\core\FS;
use app\core\Response;
use app\model\Product;
use app\model\ProductUnit;
use JetBrains\PhpStorm\NoReturn;

class ProductRepository extends AppController
{
   public function baseUnitPrice(Product $product): string
   {
      $baseUnit       = $product->baseUnit->first() ?? 'ед отсутств';
      $price          = (float)$product->getRelation('price')->price;
      $formattedPrice = $price
         ? number_format($price, 2, '.', ' ')
         : 'Цену уточняйте у менеджера';

      return "{$formattedPrice} ₽ / {$baseUnit->name}";
   }

   public function dopUnitsPrices(Product $product): string
   {
      $shippableUnits = $product->shippableUnits;
      if (!$product->shippableUnits->count()) return '';
      $price = $product->price;
      $str   = '';
      foreach ($shippableUnits as $unit) {
         $multiplier     = $unit->pivot->multiplier ?? 1;
         $formattedPrice = $price && $multiplier
            ? number_format((float)$price * $multiplier, 2, '.', ' ')
            : 'Цену уточняйте у менеджера';
         $str            .= "<div class='price-unit-row'>
                <div class='price-for-unit'>
                     {$formattedPrice}
                </div>
                ₽ /
                <div class='unit'>
                {$unit->name}<span> ({$multiplier} {$product->baseUnit->name})</span>
                </div>

            </div>";
      }
      return $str;
   }
   public function edit(int $id)
   {
      $id = Product::where('id', $id)->withTrashed()->first()['1s_id'];
      return Product::query()
         ->withTrashed()
         ->where('1s_id', $id)
         ->with('category.properties.vals')
         ->with('values')
         ->with('category.parentRecursive')
         ->with('category.parents')
         ->with('mainImages')
         ->with('manufacturer.country')
         ->with('detailImages')
         ->with('promotions')
         ->with('activePromotions')
         ->with('inactivePromotions')
         ->with('smallpackImages')
         ->with('bigpackImages')
         ->with('seo')
         ->first();
   }

   protected function mainShortSubquery($id)
   {
      return Product::query()
         ->withTrashed()
         ->orderBy('sort')
         ->with('category.properties.vals')
         ->with('category.parentRecursive')
         ->with('category.parents')
         ->with('mainImages')
         ->with('values.property')
         ->with('manufacturer.country')
         ->with('detailImages')
         ->with('smallpackImages')
         ->with('bigpackImages')
         ->with('activepromotions.unit')
         ->with('seo')
         ->with('shippableUnits')
         ->with('orderItems')
         ->where('1s_id', $id)
         ->get();
   }

   public function main(string $slug)
   {
      $slug = "%{$slug}%";
      $p    = Product::where('slug', 'Like', $slug)->withTrashed()->first();
      if (!$p) $p = Product::where('short_link', $slug)->first();
      if ($p) {
         $id      = $p['1s_id'];
         $product = $this->mainShortSubquery($id)->first();;
         return $product;
      }
      return null;
   }

//
   public function changePromotion(array $req)
   {

   }
   #[NoReturn] public function changeVal(array $req): void
   {
      $product = Product::find($req['product_id']);
      $newVal = $req['morphed']['new_id'];
      $oldVal = $req['morphed']['old_id'];

      if (!$oldVal) {
         $product->values()->attach($newVal);
         exit(json_encode(['popup' => 'Добавлен']));

      } else if (!$newVal) {
         $product->values()->detach($oldVal);
         exit(json_encode(['popup' => 'Удален']));

      } else {
         if ($newVal === $oldVal) exit(json_encode(['popup' => 'Одинаковые значения']));
         $product->values()->detach($oldVal);
         $product->values()->attach($newVal);
         exit(json_encode(['popup' => 'Поменян']));
      }
   }
   public function changeUnit(array $req): void
   {
      $productId   = $req['pivot']['product_id'];
      $unitId      = $req['morphed']['new_id'];
      $productUnit = [
         'unit_id' => $unitId,
         'multiplier' => $req['pivot']['multiplier'],
         'is_shippable' => $req['pivot']['is_shippable'],
      ];

      try {
         $unit = ProductUnit::query()
            ->updateOrCreate(
               ['product_1s_id'=> $productId,
                  'unit_id'=> $unitId],
               $productUnit);
         Response::exitWithPopup('изменено');
      } catch (\Throwable $exception) {
         Response::exitWithPopup('не изменено');
      }
   }

   public function deleteUnit(array $req): void
   {
      try {
         $productId = $req['pivot']['product_id'];
         $unitId    = $req['morphed']['old_id'];
         ProductUnit::where('product_1s_id', $productId)
            ->where('unit_id', $unitId)
            ->delete();
         Response::exitJson(['popup' => 'удален', 'ok' => 'ok']);
      } catch (\Throwable $exception) {
         Response::exitWithPopup('не удален');
      }
   }


   public function trashed()
   {
      return Product::query()
         ->with('price')
         ->onlyTrashed()
         ->with('mainImages')
         ->take(20)
         ->orderBy('id', "DESC")
         ->get();
   }

   public function list()
   {
      return Product::query()
//            ->with('price')
         ->with('mainImages')
         ->take(20)
         ->orderBy('id', "DESC")
         ->get();
   }


   public function getFilters()
   {
      $self    = new static();
      $filters = [
         'instore' => 'Показать с остатком = 0',
         'price' => 'Показать c ценой = 0',
      ];
      return FS::getFileContent('./filters.php', compact('filters'));
   }
//   public function attachMainImage(array $file, string $productId): string
//   {
//      $product = Product::query()->find($productId);
//      $mainImage = new ProductMainImageEntity($product, $file);
//
//      $mainImage->deletePreviousFile();
//      $mainImage->save();
////		$mainImage->thumbnail();
//      return $mainImage->getRelativePath();
//   }
//   public function short(string $short)
//   {
//      $self    = new self();
//      $p       = Product::where('short_link', $short)->firstOrFail();
//      $id      = $p['1s_id'];
//      $product =
//         $self->mainShortSubquery($id)
//            ->first();;
//
//      $p = $product->toArray();
//      return $product;
//   }
}