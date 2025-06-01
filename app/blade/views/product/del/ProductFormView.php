<?php

namespace app\blade\views\product\del;

use app\blade\views\admin\product\DndBuilder;
use app\model\Category;
use app\model\Manufacturer;
use app\model\Product;
use app\model\Promotion;
use app\model\Unit;
use app\repository\ProductRepository;
use app\service\FS;
use app\service\Image\ProductImageService;
use app\view\Category\CategoryFormView;
use app\view\components\Builders\CheckboxBuilder\CheckboxBuilder;
use app\view\components\Builders\ItemBuilder\ItemBuilderNew;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\SelectBuilder\optionBuilders\ArrayOptionsBuilder;
use app\view\components\Builders\SelectBuilder\optionBuilders\PluckOptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;
use app\view\Property\PropertyView;
use Illuminate\Database\Eloquent\Collection;

class ProductFormView
{

    public function __construct(
        private readonly FS $fs,
    )
    {
    }

    public function baseUnitPrice(Product $product): string
    {
        $baseUnit       = $product->baseUnit->first() ?? 'ед отсутств';
        $price          = (float)$product->getRelation('price')->price;
        $formattedPrice = $this->getFormattedPrice($price, 1);

        return "{$formattedPrice} ₽ / {$baseUnit->name}";
    }

    protected function getFormattedPrice($price, int $multiplier): string
    {
        return $price && $multiplier
            ? number_format((float)$price * $multiplier, 2, '.', ' ')
            : 'Цену уточняйте у менеджера';
    }

    public function dopUnitsPrices(Product $product, string $str = ''): array
    {
        if (!$product->shippableUnits->count()) return '';
        $shippable = [];
        foreach ($product->shippableUnits as $unit) {
            $promotion         = $product->activePromotions->first() ?? null;
            $shippable['formattedPrice']=$this->getFormattedPrice($product->price, $unit->pivot->multiplier);;
            $shippable['promotionNewPrice']=$promotion ? $this->getFormattedPrice($promotion->new_price, 1) : '';
            $shippable['promotion']=$product->activePromotions->first() ?? null;
//            $str               .= $this->fs->getContent('shippableUnitRow',
//                compact('product', 'formattedPrice', 'unit', 'promotion', 'promotionNewPrice'));
        }
        return $shippable;
    }

    public static function edit(Product $product): array
    {
        return ItemBuilderNew::build($product, 'product')
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
                ItemFieldBuilder::build('active_promotions', $product)
                    ->name('Действующие акции')
                    ->html(
                        SelectBuilder::build(
                            ArrayOptionsBuilder::build(
                                $product->activePromotions, ['count' => 'кол-о', 'active_till' => 'до', 'new_price' => 'новая цена'])
                                ->field('active_till')
                                ->get()
                        )
                            ->get()
                    )
                    ->get()
            )
            ->field(
                ItemFieldBuilder::build('art', $product)
                    ->name('Артикул')
                    ->required()
                    ->get()
            )
            ->field(
                ItemFieldBuilder::build('1s_id', $product)
                    ->name('Категория')
                    ->html(CategoryFormView::selectorByField(['1s_id' => $product->category['1s_id']]))
                    ->get()
            )
            ->field(
                ItemFieldBuilder::build('name', $product)
                    ->name('Рабочее наименование')
//                    ->contenteditable()
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
                        $product->baseUnit->name
                    )
                    ->get()
            )
            ->field(
                ItemFieldBuilder::build('instore', $product)
                    ->name('наличие')
                    ->get()
            )
            ->field(
                ItemFieldBuilder::build('main_image', $product)
                    ->name('Основная картинка')
                    ->dnd(self::mainImage($product))
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
            ->field(
                ItemFieldBuilder::build('manufacturer', $product)
                    ->name('Производитель')
                    ->html(
                        self::getManufacturer($product)
                    )
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
                    ->table(
                        self::newUnits($product)
                    )
            )
            ->tab(
                ItemTabBuilder::build('Seo')
                    ->html(
                        self::getSeo($product)
                    )
            )
//            ->tab(
//                ItemTabBuilder::build('Акции')
//                    ->html(
//                        self::promotions($product)
//                    )
//            )
//            ->tab(
//                ItemTabBuilder::build('Детальные картинки')
//                    ->html(
//                        self::getImage($product, 'detailImages', 'detail', true)
//                    )
//            )
//            ->tab(
//                ItemTabBuilder::build('Внутритарная упаковка')
//                    ->html(
//                        self::getImage($product, 'smallpackImages', 'smallpack', true)
//                    )
//            )
//            ->tab(
//                ItemTabBuilder::build('Транспортная упаковка')
//                    ->html(
//                        self::getImage($product, 'bigPackImages', 'bigpack', true)
//                    )
//            )
            ->get();
    }

    protected static function newUnits(Product $product): array
    {
        $baseUnit = $product->baseUnit;
        return Table::build($product->units)
            ->class('units')
            ->relation('units', 'attach')
            ->pageTitle("Единица")
            ->column(
                ColumnBuilder::build('unit')
                    ->removeDataField()
                    ->attach()
                    ->emptyRow(SelectBuilder::build(
                        PluckOptionsBuilder::build(Unit::pluck('name', 'id'))
                            ->get())
                        ->get())
                    ->name('Единица')
                    ->callback(function ($unit) use ($baseUnit) {
                        if ($unit->id === $baseUnit->id) {
                            return $baseUnit->name;
                        }
                        return SelectBuilder::build(
                            PluckOptionsBuilder::build(Unit::pluck('name', 'id'))
                                ->selected($unit->id)
                                ->get()
                        )
                            ->get();
                    })
                    ->get()
            )
            ->column(
                ColumnBuilder::build('multiplier')
                    ->emptyRow('1')
                    ->removeDataField()
                    ->pivot('multiplier')
                    ->name('Коэфф')
                    ->callback(function ($unit) {
                        return $unit->pivot->multiplier;
                    })
                    ->contenteditable()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('base_unit')
//                    ->pivot('base_unit')
                    ->name('Базовая ед')
                    ->removeDataField()
                    ->emptyRow(function () use ($baseUnit) {
                        return $baseUnit->name;
                    })
                    ->callback(function ($unit) use ($baseUnit) {
                        if ($unit->id === $baseUnit->id) {
                            return '';
                        }
                        return $baseUnit->name;
                    })
                    ->get()
            )
            ->column(
                ColumnBuilder::build('is_shippable')
                    ->removeDataField()
                    ->pivot('is_shippable')
                    ->emptyRow(function () {
                        return CheckboxBuilder::build()
                            ->checked(false)
                            ->data('id', 0)
//                            ->data('pivot-field', 'is_shippable')
                            ->data('pivot', 'is_shippable')
                            ->data('relation', 'units')
                            ->get();
                    })
                    ->name('Отгруж ед')
                    ->callback(function ($unit) {
                        return CheckboxBuilder::build()
                            ->checked($unit->pivot->is_shippable)
                            ->data('id', $unit->id)
                            ->data('pivot', 'is_shippable')
//                            ->data('pivot-value', $unit->pivot->is_shippable)
                            ->data('relation', 'units')
                            ->get();
                    })
                    ->get()
            )
            ->del()
            ->addButton('pivot')
            ->get();

    }

    public static function getManufacturer(Product $p): string
    {
        $select = SelectBuilder::build(
            ArrayOptionsBuilder::build(Manufacturer::all())
                ->initialOption(0, '')
                ->selected($product->manufacturer->id ?? 0)
                ->get()
        )
            ->field('manufacturer_id')
            ->get();
        return $select;
    }

    public static function mainImage(Product $product): DndBuilder
    {
        $img['src']   = APP->get(ProductImageService::class)->getRelativeImage($product);
        $img['alt']   = $product->name;
        $img['title'] = $product->name;
        $img['class'] = 'main-image';

        $dnd      = self::dnd();
        $dnd->img = $img;

        return $dnd;
    }

    public static function dnd(): DndBuilder
    {
        return DndBuilder::make('', 'add-file');
    }

//    protected static function getImage(Product $product, string $relation, string $slug, bool $many = false): string
//    {
//        $imgs = ImageView::morphImages($product, $relation);
//
//        $img = MorphBuilder::build($product, $relation, $slug, $many)
//            ->detach('detach')
//            ->html(
//                DndBuilder::make('product') . $imgs
//            )
//            ->get();
//
//        return $img;
//    }

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

    protected static function getSeo(Product $product): string
    {
        return $product->ownProperties
            ? "<div class='show'>" .
            ItemFieldBuilder::build('seo_description', $product->ownProperties)
                ->name('Description')
                ->contenteditable()
                ->relation('ownProperties')
                ->get()->toHtml('product') .
            ItemFieldBuilder::build('seo_title', $product->ownProperties)
                ->name('Title')
                ->contenteditable()
                ->relation('ownProperties')
                ->get()->toHtml('product') .
            ItemFieldBuilder::build('seo_keywords', $product->ownProperties)
                ->name('Список запросов')
                ->contenteditable()
                ->relation('ownProperties')
                ->get()->toHtml('product') .
            ItemFieldBuilder::build('seo_h1', $product->ownProperties)
                ->name('H1')
                ->contenteditable()
                ->relation('ownProperties')
                ->get()->toHtml('product') .
            ItemFieldBuilder::build('seo_article', $product->ownProperties)
                ->name('Seo article')
                ->id('seo-article')
                ->html(
                    self::getSeoArticle($product)
                )
                ->relation('ownProperties')
                ->get()->toHtml('product') .
            "</div>"
            : 'Справочник отсутствует';
    }

    public static function unitsRow(Unit $unit, string $name, bool $deletable): string
    {
        $fs       = new FS();
        $selector = SelectBuilder::build(
            ArrayOptionsBuilder::build(
                $unit->pivot->is_base
                    ? new Collection([$unit])
                    : Unit::all())
                ->initialOption()
                ->selected($unit->id)
                ->get()
        )
            ->class('name')
            ->get();;
        $shippable  = $unit->pivot->is_shippable ? 'checked' : '';
        $multiplier = self::multiplier($unit->pivot->multiplier);
        $is_base    = $unit->pivot->is_base ? 'data-isBase' : '';
        return $fs->getContent('unitRow', compact('is_base', 'selector', 'name', 'shippable', 'multiplier', 'deletable'));
    }

    private static function multiplier($mult): string
    {
        return $mult ? "<input class='multiplier' type='number' value='{$mult}'>" : "<div class='multiplier'></div>";
    }

    protected static function getDescription($product): string
    {
        ob_start();
        include __DIR__ . '/description.php';
        return ob_get_clean();
    }

    protected static function getSeoArticle($product): string
    {
        ob_start();
        include __DIR__ . '/seoArticle.php';
        return ob_get_clean();
    }

    protected static function promotions($product): string
    {
        $inactivePromotions = self::commonPromotions($product->inactivePromotions, 'inactivePromotions', 'Неактивные акции', false, false);
        $activePromotions   = self::commonPromotions($product->activePromotions, 'activePromotions', 'Активные акции', true, true);

        return $inactivePromotions . '<hr>' . $activePromotions;
    }

    private static function commonPromotions(Collection $items,
                                             string     $relation,
                                             string     $title,
                                             bool       $addButton,
                                             bool       $edit): array
    {
        $customList = Table::build($items)
            ->relation($relation, 'promotion')
            ->pageTitle($title)
            ->column(
                ColumnBuilder::build('new_price')
                    ->name('Цена по акции')
                    ->get()
            )
            ->column(ColumnBuilder::build('active_till')
                ->name('До')
                ->get()
            )
            ->column(ColumnBuilder::build('count')
                ->name('Кол-во')
                ->function(Promotion::class, 'getCount')
                ->contenteditable()
                ->get()
            );
        if ($addButton) {
            $customList = $customList->addButton();
        }
        if ($edit) {
            $customList = $customList->edit();
        }
        return $customList->get();
    }

    public static function trashed(Collection $items): array
    {
        return Table::build($items)
            ->pageTitle('Товары')
            ->column(
                ColumnBuilder::build('id')
                    ->name('ID')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('name')
                    ->name('Наименование')
                    ->contenteditable()
                    ->search()
                    ->width('1fr')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('art')
                    ->name('Артикул')
                    ->contenteditable()
                    ->search()
                    ->width('100px')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('sort')
                    ->name('Порядок')
                    ->contenteditable()
                    ->search()
                    ->width('50px')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('price')
                    ->name('Цена')
                    ->contenteditable()
                    ->width('70px')
                    ->function(ProductRepository::class, 'priceStatic')
                    ->get()
            )
            ->edit()
            ->del()
            ->addButton()
            ->get();
    }
    //    protected static function unitSelector(int $selected): string
//    {
//        return SelectBuilder::build(
//            ArrayOptionsBuilder::build(Unit::select(['name', 'id'])->get())
//                ->selected($selected)
//                ->get()
//        )
//            ->initialOption()
//            ->get();
//    }

}