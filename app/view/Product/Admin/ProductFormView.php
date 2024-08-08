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
use app\Services\ProductImageService;
use app\view\components\Builders\Dnd\DndBuilder;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;
use app\view\components\Builders\Morph\MorphBuilder;
use app\view\components\Builders\SelectBuilder\optionBuilders\ArrayOptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\components\Builders\SelectBuilder\SelectListBuilder;
use app\view\components\Builders\SelectBuilder\SelectNewBuilder;
use app\view\Image\ImageView;
use app\view\Property\PropertyView;
use app\view\Unit\UnitFormView;
use Illuminate\Database\Eloquent\Collection;

class ProductFormView
{
    protected static function getUnit(int $selected, string $field): string
    {
        return SelectBuilder::build(
                ArrayOptionsBuilder::build(Unit::select(['name', 'id'])->get())
                    ->selected($selected)
                    ->get()
            )
                ->field($field)
                ->initialOption()
                ->get();
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
                ItemFieldBuilder::build('instore', $product)
                    ->name('наличие')
                    ->get()
            )
            ->field(
                ItemFieldBuilder::build('instore', $product)
                    ->name('Основная картинка')
                    ->html(self::mainImage($product))
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

    public static function mainImage(Product $p)
    {
        $dnd  = DndBuilder::make('product/uploads', 'add-file');
        $src  = (new ProductImageService)->getRelativeImage($p);
        $name = $p->name;
        return "<div class='dnd-container'>{$dnd}<img src = '{$src}' title = '{$name}' alt = '{$name}'/></div>";
    }

//77.222.62.219
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
    public static function unitsRow(Unit $unit, string $name, bool $deletable): string
    {
        $fs         = new FS(__DIR__ );
        $selector   = UnitFormView::selectorNew($unit);
        $shippable  = $unit->pivot->is_shippable ? 'checked' : '';
        $multiplier = self::multiplier($unit->pivot->multiplier);
        $is_base = $unit->pivot->is_base?'data-isBase':'';
        return $fs->getContent('unitRow', compact('is_base','selector', 'name', 'shippable', 'multiplier', 'deletable'));
    }

    protected static function units(Product $product): string
    {
        $fs         = new FS(__DIR__ );
        $baseUnit   = $product->units()->where('is_base', 1)->first();
        $units      = $product->units;
        $noneSelector   = UnitFormView::noneSelector($baseUnit);
        $multiplier = self::multiplier(null);
        return $fs->getContent('units', compact('units', 'noneSelector', 'baseUnit', 'multiplier'));
    }
    private static function multiplier($mult): string
    {
        return $mult ? "<input class='multiplier' type='number' value='{$mult}'>" : "<div class='multiplier'></div>";
    }
















    protected static function getDescription($product): string
    {
        ob_start();
        include __DIR__ . '/../description.php';
        return ob_get_clean();
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


}