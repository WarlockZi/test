<?php


namespace app\view\Category;


use app\model\Category;
use app\model\CategoryProperty;
use app\Repository\CategoryRepository;
use app\view\components\Builders\CheckboxBuilder\CheckboxBuilder;
use app\view\components\Builders\Dnd\DndBuilder;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\Morph\MorphBuilder;
use app\view\components\Builders\SelectBuilder\optionBuilders\TreeABuilder;
use app\view\components\Builders\SelectBuilder\optionBuilders\TreeOptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;
use app\view\Image\ImageView;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class CategoryFormView
{
    public static function edit(Category $category): string
    {
        try {
            return ItemBuilder::build($category, 'category')
                ->pageTitle('Категория :  ' . $category->name)
                ->field(
                    ItemFieldBuilder::build('id', $category)
                        ->name('ID')
                        ->get()
                )
                ->field(
                    ItemFieldBuilder::build('slug', $category)
                        ->name('Адрес')
                        ->html(
                            "<a href='$category->href}'>{$category->href}</a>"
                        )
                        ->get()
                )
                ->field(
                    ItemFieldBuilder::build('name', $category)
                        ->name('Наименование в 1c')
                        ->contenteditable()
                        ->required()
                        ->get()
                )
                ->field(
                    ItemFieldBuilder::build('show_front', $category)
                        ->name('Показывать на главоной')
                        ->html(
                            CheckboxBuilder::build('show_front',
                                $category->show_front)
                                ->get()
                        )
                        ->get()
                )
                ->field(
                    ItemFieldBuilder::build('category_id', $category)
                        ->name('Принадлежит')
                        ->html(
                            self::categorySelector($category)
                        )
                        ->get()
                )
                ->tab(
                    ItemTabBuilder::build('Основная картинка')
                        ->html(
                            MorphBuilder::build($category, 'mainImages', 'main')
                                ->html(DndBuilder::make('category'))
                                ->html(ImageView::morphImages($category, 'mainImages'))
                                ->get()
                        )
                )
                ->tab(
                    ItemTabBuilder::build('Товары категории')
                        ->html(
                            self::getProducts($category)
                        )
                )
                ->tab(
                    ItemTabBuilder::build('Св-ва категории')
                        ->html(
                            self::properties($category->properties)
                        )
                )
                ->tab(
                    self::getChildCategories($category)

                )
                ->tab(
                    ItemTabBuilder::build('Удаленные Подкатегории')
                        ->html(
                            Table::build($category['childrenDeleted'])
                                ->pageTitle('Удаленные подкатегории')
                                ->column(
                                    ColumnBuilder::build('id')
                                        ->width('40px')
                                        ->get()
                                )
                                ->column(
                                    ColumnBuilder::build('name')
                                        ->name("Назввание")
                                        ->contenteditable()
                                        ->get()
                                )
                                ->relation('childrenDeleted', 'category')
                                ->edit()
                                ->del()
                                ->addButton('ajax')
                                ->get()
                        )
                )
                ->tab(
                    ItemTabBuilder::build('seo')
                        ->html(
                            self::getSeo($category->ownProperties)
                        )

                )
                ->toList('adminsc/category/table', 'К списку категорий')
                ->get();
        } catch (Throwable $exception) {
            return $exception;
        }
    }

    public static function selector(int $selected = 0, int $excluded = -1): string
    {
        return SelectBuilder::build(
            TreeOptionsBuilder::build(CategoryRepository::treeAll(), 'children_recursive', 2)
                ->initialOption()
                ->selected($selected)
                ->excluded($excluded)
                ->get()
        )
            ->field('category_id')
            ->class('categories')
            ->get();
    }

    public static function productFilterSelector(array $req): string
    {
        $selected = $req['category'] ?? 0;
        return SelectBuilder::build(
            TreeOptionsBuilder::build(CategoryRepository::treeAll(), 'children_recursive', 2)
                ->initialOption()
                ->selected($selected)
                ->get()
        )
            ->field('category_id')
            ->name('category')
            ->class('categories')
            ->get();
    }

    public static function getChildCategories(Category $category): ItemTabBuilder
    {
        return ItemTabBuilder::build('Подкатегории')
            ->html(
                Table::build($category['childrenNotDeleted'])
                    ->pageTitle('Подкатегории')
                    ->column(
                        ColumnBuilder::build('id')
                            ->width('40px')
                            ->get()
                    )
                    ->column(
                        ColumnBuilder::build('name')
                            ->name("Назввание")
                            ->contenteditable()
                            ->get()
                    )
                    ->relation('childrenNotDeleted', 'category')
                    ->edit()
                    ->del()
                    ->addButton('ajax')
                    ->get()
            );
    }

    protected static function getSeo(CategoryProperty|null $categoryProperty): string
    {
        if (!$categoryProperty) return '';
        return "<div class='show'>" .
            ItemFieldBuilder::build('seo_title', $categoryProperty)
                ->name('Title')
                ->contenteditable()
                ->relation('ownProperties')
                ->get()->toHtml('product') .
            ItemFieldBuilder::build('seo_description', $categoryProperty)
                ->name('Description')
                ->contenteditable()
                ->relation('ownProperties')
                ->get()->toHtml('product') .
            ItemFieldBuilder::build('seo_keywords', $categoryProperty)
                ->name('Key words')
                ->contenteditable()
                ->relation('ownProperties')
                ->get()->toHtml('product') .
            ItemFieldBuilder::build('seo_h1', $categoryProperty)
                ->name('h1')
                ->contenteditable()
                ->relation('ownProperties')
                ->get()->toHtml('product') .
            ItemFieldBuilder::build('seo_article', $categoryProperty)
                ->name('Seo article')
                ->contenteditable()
                ->relation('ownProperties')
                ->get()->toHtml('product') .
            ItemFieldBuilder::build('seo_path', $categoryProperty)
                ->name('Path')
                ->contenteditable()
                ->relation('ownProperties')
                ->get()->toHtml('product') .
            "</div>";

    }

    protected static function getProducts(Category $category): string
    {
        return Table::build($category['products'])
            ->pageTitle('Товары категории')
            ->relation('products', 'product')
            ->addButton('ajax')
            ->column(
                ColumnBuilder::build('id')
                    ->width("40px")
                    ->get()
            )
            ->column(
                ColumnBuilder::build('name')
                    ->name("Название")
                    ->get()
            )
            ->column(
                ColumnBuilder::build('art')
                    ->name("Арт")
                    ->search()
                    ->width("100px")
                    ->get()
            )
            ->edit()
            ->del()
            ->get();
    }

    public static function categorySelector(Category $category): string
    {
        $tree1 = TreeOptionsBuilder::build(
            CategoryRepository::treeAll(),
            'children_recursive', 2)
            ->initialOption()
            ->selected($category->category_id)
            ->excluded($category->id)
            ->get();

        return SelectBuilder::build(
            $tree1
        )
            ->field('category_id')
            ->get();

    }

    public static function properties(Collection $properties): string
    {
        $content = Table::build($properties)
            ->pageTitle('Св-ва категории')
//            ->model('property')
            ->relation('properties', 'property')
            ->column(
                ColumnBuilder::build('name')
                    ->name('Наимен')
                    ->contenteditable()
                    ->get()
            )
            ->edit()
            ->addButton('ajax')
            ->get();

        return $content;
    }

    public static function list(): string
    {
        $tree = TreeABuilder::build(
            CategoryRepository::treeAll(), 'children_recursive', 2)
            ->href('/adminsc/category/edit/')
            ->get();
        return "<ul class='category-tree'>" . $tree . "</ul>";
    }
}