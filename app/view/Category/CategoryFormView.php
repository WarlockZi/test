<?php


namespace app\view\Category;


use app\model\Category;
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
                            "<a href='/category/{$category->slug}'>{$category->slug}</a>"
                        )
                        ->get()
                )
                ->field(
                    ItemFieldBuilder::build('name', $category)
                        ->name('Наименование')
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
                            Table::build($category['products'])
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
                                ->get()
                        )
                )
                ->tab(
                    ItemTabBuilder::build('Св-ва категории')
                        ->html(
                            self::properties($category->properties)
                        )
                )
                ->tab(
                    ItemTabBuilder::build('Подкатегории')
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
                        )
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
                            self::getSeo($category)
                        )

                )
                ->toList('adminsc/category/table', 'К списку категорий')
                ->get();
        } catch (Throwable $exception) {
            return $exception;
        }

    }

    protected static function getSeo(Category $category): string
    {
//        $p = $category->properties;
        $p = $category->ownProperties;
        return "<div class='show'>" .
            ItemFieldBuilder::build('seo_description', $category->ownProperties)
                ->name('Description')
                ->contenteditable()
                ->relation('ownProperties')
                ->get()->toHtml('product') .
            ItemFieldBuilder::build('seo_title', $category->ownProperties)
                ->name('Title')
                ->contenteditable()
                ->relation('ownProperties')
                ->get()->toHtml('product') .
            ItemFieldBuilder::build('seo_keywords', $category->ownProperties)
                ->name('Key words')
                ->contenteditable()
                ->relation('ownProperties')
                ->get()->toHtml('product') .
            "</div>";

    }


    protected static function categorySelector(Category $category): string
    {
        return SelectBuilder::build(
            TreeOptionsBuilder::build(
                CategoryRepository::treeAll(),
                'children_recursive', 2)
                ->initialOption()
                ->selected($category->category_id)
                ->excluded($category->id)
                ->get()
        )
//            ->relation('')
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