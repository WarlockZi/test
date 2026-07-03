<?php

namespace app\blade\views\product;

use app\blade\View;
use app\blade\views\admin\product\DndBuilder;
use app\model\Category;
use app\model\Manufacturer;
use app\model\Product;
use app\model\Promotion;
use app\model\Unit;
use app\repository\ProductRepository;
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
use Throwable;

class ProductFormView
{
    public function __construct()
    {
    }

    public static function edit(?Product $product): array
    {
        if (!$product) return [];
        try {
            return ItemBuilderNew::build($product, 'product')
                ->pageTitle('Товар :  ' . $product['name'])
                ->field(
                    ItemFieldBuilder::build('art', $product)
                        ->name('Артикул')
                        ->required()
                        ->get()
                )
                ->field(
                    ItemFieldBuilder::build('name', $product)
                        ->name('Рабочее наименование')
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
                        ->name('Текстовое описание')
                        ->html(self::getDescription($product))
                        ->get()
                )
                ->field(
                    ItemFieldBuilder::build('s_id', $product)
                        ->name('Категория')
                        ->html(CategoryFormView::selectorByField(['s_id' => $product?->category?->s_id]))
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
                    ItemFieldBuilder::build('id', $product)
                        ->name('ID')
                        ->get()
                )
                ->field(
                    ItemFieldBuilder::build('1s_id', $product)
                        ->name('1s_ID')
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
                            self::units($product)
                        )
                )
                ->tab(
                    ItemTabBuilder::build('Seo')
                        ->html(
                            self::getSeo($product)
                        )
                )
                ->get();
        } catch (Throwable $exception) {
            $exc = $exception;
        }
        return [];
    }

    protected static function units(Product $product): array
    {
        try {

            $p = $product->toArray();
            return Table::build($product->units)
                ->data([
                    'jscallbacksfile' => 'product',
                    'jsonload' => 'product',
                    'relation' => 'units',
                ])
                ->class('units')
                ->pageTitle("Единица")
                ->column(
                    ColumnBuilder::build('Единица')
                        ->data(['jscallback' => 'changeunit'])
                        ->width('clamp(100px,10vw,130px)')
                        ->emptyRow(function () {
                            return SelectBuilder::build(
                                PluckOptionsBuilder::build(Unit::pluck('name', 'id'))
                                    ->initialOption()
                                    ->get())
                                ->removeSelectNewAttr()
                                ->get();
                        })
                        ->callback(function ($unit) {
                            return SelectBuilder::build(
                                PluckOptionsBuilder::build(Unit::pluck('name', 'id'))
                                    ->selected($unit->id)
                                    ->get()
                            )->get();
                        })
                        ->get()
                )
                ->column(
                    ColumnBuilder::build('Пониж коэфф')
                        ->emptyRow('')
                        ->width('clamp(40px,7vw,55px)')
                        ->data(['pivot' => 'divider'])
                        ->data(['jscallback' => 'changemultiplier'])
                        ->callback(function ($unit) {
                            return $unit->pivot->divider ?? '';
                        })
                        ->contenteditable()
                        ->get()

                )
                ->column(
                    ColumnBuilder::build('Повыш коэфф')
                        ->emptyRow('')
                        ->width('clamp(40px,7vw,55px)')
                        ->data(['pivot' => 'multiplier',
                            'jscallback' => 'changemultiplier'
                        ])
                        ->callback(function ($unit) {
                            return $unit->pivot->multiplier ?? '';
                        })
                        ->contenteditable()
                        ->get()
                )
                ->column(
                    ColumnBuilder::build('Отгруж ед')
                        ->emptyRow(function () {
                            return CheckboxBuilder::build()
                                ->checked(true)
                                ->data(['id' => 0, 'pivot' => 'units', 'field' => 'is_shippable'])
                                ->get()->toHtml();
                        })
                        ->callback(function ($unit) {
                            return CheckboxBuilder::build()
                                ->checked($unit->pivot->is_shippable)
                                ->data(['id' => $unit->pivot->id, 'pivot' => 'units', 'field' => 'is_shippable'])
                                ->get()->toHtml();
                        })
                        ->get()
                )
                ->column(
                    ColumnBuilder::build('Цены')
                        ->data(['pivot' => 'price'])
                        ->callback(function ($unit) {
                            return (float)$unit->pivot->price ?? '';
                        })
                        ->get()
                )
                ->column(
                    ColumnBuilder::build('Из 1s')
                        ->data([
                            'pivot' => 'units',
                            'field' => 'from_1s',
                        ])
                        ->callback(function ($unit) {
                            return $unit->pivot->is_from_1s ?? '';
                        })
                        ->get()
                )
                ->del()
                ->addButton()
                ->get();
        } catch (Throwable $exception) {
            $exc = $exception;
            return ['error' => 'Ошибка в таблице единиц'];
        }
    }

    protected function getFormattedPrice($price, int $multiplier): string
    {
        return $price && $multiplier
            ? number_format((float)$price * $multiplier, 2, '.', ' ')
            : 'Цену уточняйте у менеджера';
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
        $img['src']   = image($product->ownProperties->main_image);
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
                ->data(['relation' => 'ownProperties'])
                ->get()->toHtml() .
            ItemFieldBuilder::build('seo_title', $product->ownProperties)
                ->name('Title')
                ->contenteditable()
                ->data(['relation' => 'ownProperties'])
                ->get()->toHtml() .
            ItemFieldBuilder::build('seo_keywords', $product->ownProperties)
                ->name('Keywords')
                ->contenteditable()
                ->data(['relation' => 'ownProperties'])
                ->get()->toHtml() .
            ItemFieldBuilder::build('seo_h1', $product->ownProperties)
                ->name('H1')
                ->contenteditable()
                ->data(['relation' => 'ownProperties'])
                ->get()->toHtml() .
            ItemFieldBuilder::build('seo_article', $product->ownProperties)
                ->name('Seo article')
                ->data(['id' => 'seo-article',
                    'quill' => 'admin'])
                ->html(
                    self::getSeoArticle($product)
                )
                ->data(['relation' => 'ownProperties'])
                ->get()->toHtml('product') .
            "</div>"
            : 'Справочник отсутствует';
    }


    private static function divider($mult): string
    {
        return $mult ? "<input class='divider' type='number' value='{$mult}'>" : "<div class='divider'></div>";
    }

    protected static function getDescription($product): string
    {
        $blade = APP->get(View::class);
        return $blade->render('product.description', ['product' => $product]);
    }

    protected static function getSeoArticle($product): string
    {
        $blade = APP->get(View::class);
        return $blade->render('product.seoArticle', ['product' => $product]);
    }

    protected static function promotions($product): string
    {
        $inactivePromotions = self::commonPromotions($product->inactivePromotions, 'inactivePromotions', 'Неактивные акции', false, false);
        $activePromotions   = self::commonPromotions($product->activePromotions, 'activePromotions', 'Активные акции', true, true);

        return $inactivePromotions . '<hr>' . $activePromotions;
    }

    private static function commonPromotions(
        Collection $items,
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

    public function dopUnitsPrices(Product $product, string $str = ''): array
    {
        if (!$product->shippableUnits->count()) return [];
        $shippable = [];
        foreach ($product->shippableUnits as $unit) {
            $promotion                   = $product->activePromotions->first() ?? null;
            $shippable['formattedPrice'] = $this->getFormattedPrice($product->price, $unit->pivot->divider);;
            $shippable['promotionNewPrice'] = $promotion ? $this->getFormattedPrice($promotion->new_price, 1) : '';
            $shippable['promotion']         = $product->activePromotions->first() ?? null;
        }
        return $shippable;
    }
}