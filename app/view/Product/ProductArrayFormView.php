<?php


namespace app\view\Product;

use app\core\FS;
use app\model\Category;
use app\model\Manufacturer;
use app\model\Product;
use app\model\Promotion;
use app\model\Seo;
use app\model\Unit;
use app\model\User;
use app\Repository\CategoryRepository;
use app\view\components\Builders\Builder;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;
use app\view\components\Builders\SelectBuilder\ArrayOptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectListBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\components\Builders\SelectBuilder\SelectNewBuilder;
use app\view\components\ItemBuilder\ItemArrayBuilder;
use app\view\components\ItemBuilder\ItemArrayFieldBuilder;
use app\view\components\ItemBuilder\ItemArrayTabBuilder;
use app\view\Property\PropertyView;
use app\view\Unit\UnitFormView;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


class ProductArrayFormView
{

   public static function list(\Illuminate\Database\Eloquent\Collection $items, string $title = ''): string
   {
      return MyList::build(Product::class)
         ->pageTitle($title)
         ->column(
            ListColumnBuilder::build('id')
               ->name('ID')
               ->get()
         )
         ->column(
            ListColumnBuilder::build('name')
               ->name('Наименование')
               ->contenteditable()
               ->search()
               ->width('1fr')
               ->get()
         )
         ->column(
            ListColumnBuilder::build('art')
               ->name('Артикул')
               ->contenteditable()
               ->search()
               ->width('100px')
               ->get()
         )
         ->column(
            ListColumnBuilder::build('sort')
               ->name('Порядок')
               ->contenteditable()
               ->search()
               ->width('50px')
               ->get()
         )
         ->column(
            ListColumnBuilder::build('price')
               ->name('Цена')
               ->contenteditable()
               ->width('70px')
//                    ->function(ProductRepository::class, 'priceStatic')
               ->get()
         )
         ->items($items)
         ->edit()
         ->del()
         ->addButton('ajax')
         ->get();
   }

   protected static function units(Product $product): string
   {
      $fs         = new FS(__DIR__ . '/Admin');
      $p          = $product->toArray();
      $baseUnit   = $product->units()->where('is_base', 1)->first();
      $units      = $product->units;
      $noneSelector   = UnitFormView::noneSelector($baseUnit);
      $multiplier = self::multiplier(null);
      return $fs->getContent('units', compact('units', 'noneSelector', 'baseUnit', 'multiplier'));
   }

   public static function unitsRow(Unit $unit, string $name, bool $deletable): string
   {
      $fs         = new FS(__DIR__ . '/Admin');
      $selector   = UnitFormView::selectorNew($unit);
      $shippable  = $unit->pivot->is_shippable ? 'checked' : '';
      $multiplier = self::multiplier($unit->pivot->multiplier);
      $is_base = $unit->pivot->is_base?'data-isBase':'';
      return $fs->getContent('unitRow', compact('is_base','selector', 'name', 'shippable', 'multiplier', 'deletable'));
   }

   private static function multiplier($mult): string
   {
      return $mult ? "<input class='multiplier' type='number' value='{$mult}'>" : "<div class='multiplier'></div>";
   }


   public static function edit(Model $product): string
   {
      $p = $product->toArray();
      return ItemArrayBuilder::build($product, 'product')
         ->pageTitle('Товар :  ' . $product['name'])
         ->field(
            ItemArrayFieldBuilder::build('slug', $product)
               ->name('Адрес')
               ->html(
                  "<a href='/product/{$product->slug}'>{$product->slug}</a>"
               )
               ->get()
         )
         ->field(
            ItemArrayFieldBuilder::build('Акции', $product)
               ->name('Действующие акции')
               ->dataField('promotions')
               ->html(
                  SelectBuilder::build(
                     ArrayOptionsBuilder::build($product->activePromotions, ['count' => 'кол-о', 'active_till' => 'до', 'new_price' => 'новая цена'])
                        ->get()
                  )
                     ->get()
               )
               ->get()
         )
         ->field(
            ItemArrayFieldBuilder::build('art', $product)
               ->name('Артикул')
               ->contenteditable()
               ->required()
               ->get()
         )
         ->field(
            ItemArrayFieldBuilder::build('category_id', $product)
               ->name('Категория')
               ->html(CategoryRepository::selector($product->category_id))
               ->get()
         )
         ->field(
            ItemArrayFieldBuilder::build('name', $product)
               ->name('Рабочее наименование')
               ->contenteditable()
               ->required()
               ->get()
         )
         ->field(
            ItemArrayFieldBuilder::build('print_name', $product)
               ->name('Наименование для печати')
               ->contenteditable()
               ->required()
               ->get()
         )
         ->field(
            ItemArrayFieldBuilder::build('base_unit', $product)
               ->name('Базовая единица')
               ->html(
                  self::getBaseUnit($product->baseUnit->id ?? 0, 'base_unit')
               )
               ->get()
         )
         ->field(
            ItemArrayFieldBuilder::build('manufacturer', $product)
               ->name('Производитель')
               ->html(
                  SelectListBuilder::build()
                     ->collection(Manufacturer::all())
                     ->item($product)
                     ->field('manufacturer_id')
                     ->initialOption('', 0)
                     ->selected($product->manufacturer->id ?? 0)
                     ->get()
               )
               ->get()
         )
         ->field(
            ItemArrayFieldBuilder::build('instore', $product)
               ->name('Наличие')
               ->get()
         )
         ->field(
            ItemArrayFieldBuilder::build('price', $product)
               ->name('Цена')
               ->html($product->price)
               ->get()
         )
         ->field(
            ItemArrayFieldBuilder::build('main_image', $product)
               ->name('Основная картинка')
               ->html(ProductView::mainImage($product))
               ->get()
         )
         ->field(
            ItemArrayFieldBuilder::build('description', $product)
               ->name('Описание')
               ->html(self::getDescription($product))
               ->get()
         )
         ->field(
            ItemArrayFieldBuilder::build('id', $product)
               ->name('ID')
               ->get()
         )
         ->field(
            ItemArrayFieldBuilder::build('1s_id', $product)
               ->name('1s_ID')
               ->get()
         )
         ->field(
            ItemArrayFieldBuilder::build('sort', $product)
               ->name('Порядок')
               ->contenteditable()
               ->get()
         )
          ->field(
              ItemArrayFieldBuilder::build('deleted_at', $product)
                  ->name('Удален')
                  ->get()
          )
         ->tab(
            ItemArrayTabBuilder::build('Свойства товара')
               ->html(
                  self::getProperties($product)
               )
         )
         ->tab(
            ItemArrayTabBuilder::build('Единицы')
               ->html(
                  self::units($product)
               )
         )
         ->tab(
            ItemArrayTabBuilder::build('Seo')
               ->html(
                  self::getSeo($product)
               )
         )
         ->tab(
            ItemArrayTabBuilder::build('История акций')
               ->html(
                  self::promotions($product)
               )
         )
         ->get();
   }
   private static function getDescription(Product $product): string
   {
      $fs = new FS(__DIR__);
      return $fs->getContent('description',compact('product'));
   }

   protected static function getBaseUnit(int $selected, string $field): string
   {
      $html =
         SelectBuilder::build(
            ArrayOptionsBuilder::build(Unit::select(['name', 'id'])->get())
               ->selected($selected)
               ->get()
         )
            ->field($field)
            ->initialOption('', 0)
            ->get();
      return $html;
   }

   protected static function getSeo($product): string
   {
      $seo = $product->seo ?? new Seo();
      $r   = "<div class='show'>" .
         ItemArrayFieldBuilder::build('description', $seo)
            ->name('Description')
            ->contenteditable()
            ->get()->toHtml('product') .
         ItemArrayFieldBuilder::build('title', $seo)
            ->name('Title')
            ->contenteditable()
            ->get()->toHtml('product') .
         ItemArrayFieldBuilder::build('keywords', $seo)
            ->name('Key words')
            ->contenteditable()
            ->get()->toHtml('product') .
         "</div>";
      return $r;
   }

   protected static function promotions($product): string
   {
      return MyList::build(Promotion::class)
         ->relation('promotions')
         ->items($product->promotions)
         ->column(
            ListColumnBuilder::build('new_price')
               ->name('Цена по акции')
               ->get()
         )
         ->column(ListColumnBuilder::build('active_till')
            ->name('До')
            ->get()
         )
         ->column(ListColumnBuilder::build('Количество')
            ->function(Promotion::class, 'getCount')
            ->contenteditable()
            ->get()
         )
         ->edit()
         ->addButton('ajax')
         ->get();
   }

   protected static function getSelect(Category $category, Product $product): string
   {
      $str = "<a href='/adminsc/category/edit/$category->id' class='category'>{$category->name}</a>";
      foreach ($category->properties as $property) {
         $str .= PropertyView::getProductSelector($property, $product);
      }
      return $str;
   }

   protected static function getProperties(Product $product, string $str = ''): string
   {
      $currentCategory = $product->category;

      while ($currentCategory) {
         $str             .= self::getSelect($currentCategory, $product);
         $currentCategory = $currentCategory->parentRecursive;
      }
      return "<div class='values'>$str</div>";
   }

   protected static function clean(string $str): string
   {
      $builder = new Builder();
      return $builder->clean($str);
   }

   public static function getCardDetailImage($image): string
   {
      $im = "<img class = 'detail-image' src='{$image->getFullPath($image)}' alt=''></img>";
      return "<div class='detail-image-wrap'>{$im}</div>";
   }

   public static function getCardImages(string $title, Collection $collection, string $class = 'detail-images-wrap')
   {
      ob_start();
      $detail_image = '';
      foreach ($collection as $image) {
         $detail_image .= self::getCardDetailImage($image);
      }
      include ROOT . '/app/view/Product/card/detail_images.php';
      return ob_get_clean();
   }

   public static function getManagerSelector()
   {
      $u      = User::where('rights', 'LIKE', '%role_manager%')->get();
      $select = SelectNewBuilder::build(
         ArrayOptionsBuilder::build($u)
            ->initialOption()
            ->get()
      )
         ->get();
      return $select;
   }
}