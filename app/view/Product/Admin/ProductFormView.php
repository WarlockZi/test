<?php
namespace app\view\Product\Admin;

use app\core\FS;
use app\model\Category;
use app\model\Manufacturer;
use app\model\Product;
use app\model\Promotion;
use app\model\Unit;
use app\Repository\CategoryRepository;
use app\Repository\ProductRepository;
use app\view\components\Builders\Builder;
use app\view\components\Builders\Dnd\DndBuilder;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;
use app\view\components\Builders\Morph\MorphBuilder;
use app\view\components\Builders\SelectBuilder\ArrayOptionsBuilder;
use app\view\components\Builders\SelectBuilder\ListSelectBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\components\Builders\SelectBuilder\SelectNewBuilder;
use app\view\Image\ImageView;

use app\view\Product\ProductView;
use app\view\Property\PropertyView;

use app\view\Unit\UnitFormView;
use Illuminate\Database\Eloquent\Collection;

class ProductFormView
{
   protected static function getUnit(int $selected, string $field): string
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

   protected static function units(Product $product): string
   {
      $baseUnit = $product->baseUnit;
      if (!$baseUnit) return 'Базовая единица не выбрана';
      $baseEqualsMainUnit = ProductView::baseEqualsMainUnit($product);
      $selector           = UnitFormView::selectorNew($baseUnit->id);
      return FS::getFileContent(ROOT . '/app/view/Product/Admin/units.php',
         compact('baseUnit', 'selector', 'baseEqualsMainUnit'));
   }

   public static function edit(Product $product): string
   {
      return ItemBuilder::build($product, 'product')
         ->pageTitle('Товар :  ' . $product['name'])
         ->field(
            ItemFieldBuilder::build('slug', $product)
               ->name('Адрес')
               ->html(
                  "<a href='/product/{$product->slug}'>{$product->slug}</a>"
               )
               ->get()
         )
         ->field(
            ItemFieldBuilder::build('Акции', $product)
               ->name('Действующие акции')
               ->html(
                  SelectNewBuilder::build(
                     ArrayOptionsBuilder::build($product->activePromotions, ['count' => 'кол-о', 'active_till' => 'до', 'new_price' => 'новая цена'])
                        ->get()
                  )
                     ->get()
               )
               ->get()
         )
         ->field(
            ItemFieldBuilder::build('art', $product)
               ->name('Артикул')
               ->contenteditable()
               ->required()
               ->get()
         )
         ->field(
            ItemFieldBuilder::build('category_id', $product)
               ->name('Категория')
               ->html(CategoryRepository::selector($product->category_id))
               ->get()
         )
         ->field(
            ItemFieldBuilder::build('name', $product)
               ->name('Рабочее наименование')
               ->contenteditable()
               ->required()
               ->get()
         )
         ->field(
            ItemFieldBuilder::build('print_name', $product)
               ->name('Наименование для печати')
               ->contenteditable()
               ->required()
               ->get()
         )
         ->field(
            ItemFieldBuilder::build('base_unit', $product)
               ->name('Базовая единица')
               ->html(
                  self::getUnit($product->baseUnit->id ?? 0, 'base_unit')
               )
               ->get()
         )
         ->field(
            ItemFieldBuilder::build('manufacturer', $product)
               ->name('Производитель')
               ->html(
                  ListSelectBuilder::build()
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
            ItemFieldBuilder::build('instore', $product)
               ->name('наличие')
               ->get()
         )
         ->field(
            ItemFieldBuilder::build('instore', $product)
               ->name('Основная картинка')
               ->html(ProductView::mainImage($product))
               ->get()
         )
         ->field(
            ItemFieldBuilder::build('description', $product)
               ->name('Описание')
               ->html(self::getDescription($product))
               ->get()
         )
         ->field(
            ItemFieldBuilder::build('id', $product)
               ->name('ID')
               ->get()
         )
         ->field(
            ItemFieldBuilder::build('1s_id', $product)
               ->name('1s_ID')
               ->get()
         )
         ->field(
            ItemFieldBuilder::build('sort', $product)
               ->name('Порядок')
               ->contenteditable()
               ->get()
         )
          ->field(
            ItemFieldBuilder::build('deleted_at', $product)
               ->name('Удален')
               ->get()
         )
         ->tab(
            ItemTabBuilder::build('Свойства товара')
               ->html(
                  self::getProperties($product)
               )
         )
         ->tab(
            ItemTabBuilder::build('Единицы')
               ->html(
                  self::units($product)
               )
         )
         ->tab(
            ItemTabBuilder::build('Seo')
               ->html(
                  self::getSeo($product)
               )
         )
         ->tab(
            ItemTabBuilder::build('История акций')
               ->html(
                  self::promotions($product)
               )
         )
         ->tab(
            ItemTabBuilder::build('Детальные картинки')
               ->html(
                  self::getImage($product, 'detailImages', 'detail', true)
               )
         )
         ->tab(
            ItemTabBuilder::build('Внутритарная упаковка')
               ->html(
                  self::getImage($product, 'smallpackImages', 'smallpack', true)
               )
         )
         ->tab(
            ItemTabBuilder::build('Транспортная упаковка')
               ->html(
                  self::getImage($product, 'bigPackImages', 'bigpack', true)
               )
         )
         ->get();
   }

   protected static function getImage(Product $product, string $relation, string $slug, bool $many = false): string
   {
      $imgs = ImageView::morphImages($product, $relation);

      $img = MorphBuilder::build($product, $relation, $slug, $many)
         ->detach('detach')
         ->html(
            DndBuilder::make('product') . $imgs
         )
         ->get();

      return $img;
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

   protected static function getSeo($product): string
   {
      return "<div class='show'>" .
         ItemFieldBuilder::build('description', $product)
            ->name('Description')
            ->contenteditable()
            ->get()->toHtml('product') .
         ItemFieldBuilder::build('title', $product)
            ->name('Title')
            ->contenteditable()
            ->get()->toHtml('product') .
         ItemFieldBuilder::build('keywords', $product)
            ->name('Key words')
            ->contenteditable()
            ->get()->toHtml('product') .
         "</div>";
   }

   protected static function getDescription($product): string
   {
      return include __DIR__ . '/../description.php';
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

   public static function trashed(Collection $items): string
   {
      return MyList::build(Product::class)
      ->pageTitle('Товары')
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
            ->function(ProductRepository::class, 'priceStatic')
            ->get()
      )
      ->items($items)
      ->edit()
      ->del()
      ->addButton('ajax')
      ->get();
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


   public static function getCardImages(string $title, Collection $collection, string $class = 'detail-images-wrap'): false|string
   {
      ob_start();
      $detail_image = '';
      foreach ($collection as $image) {
         $detail_image .= self::getCardDetailImage($image);
      }
      include ROOT . '/app/view/Product/card/detail_images.php';
      return ob_get_clean();
   }
   //
//	public static function renderProperty($property)
//	{
//		return FS::getFileContent(ROOT . '/app/view/Product/property.php', compact('property'));
//	}
}