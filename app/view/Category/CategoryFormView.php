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
    public static function sitemap()
    {
        $cat = CategoryRepository::treeAll()->toArray();
        $uls = '';
        foreach ($cat as $item) {
            $sti = self::mapCategories($item);
            $uls .= $sti;
        }
        $ul = "<ul>{$uls}</ul>";
        echo($ul);

    }

    protected static function mapCategories(array $cat, string $string = ''): string
    {
        foreach ($cat as $item) {
            $string .= $cat['name'] . "<br>";
            if ($cat['children_recursive']) {
                self::mapCategories($cat['children_recursive'], $string);
            } else {
                $string .= $cat['name'] . "<br>";
            }
        }
        return $string;
    }


    public static function edit(Category $category): string
    {
        try {
            return ItemBuilder::build($category, 'category')
                ->pageTitle('Категория :  ' . $category->name)
                ->field(
                    ItemFieldBuilder::build('slug', $category)
                        ->name('Адрес')
                        ->html(
                            "<a href='$category->href'>{$category->href}</a>"
                        )
                        ->get()
                )
                ->field(
                    ItemFieldBuilder::build('name', $category)
                        ->name('Наименование в 1c')
//                        ->contenteditable()
                        ->required()
                        ->get()
                )

                ->field(
                    ItemFieldBuilder::build('show_front', $category)
                        ->name('Показывать на главоной')
                        ->html(
                            CheckboxBuilder::build()
                                ->field('show_front',$category->show_front)
                                ->get()
                        )
                        ->get()
                )
                ->field(
                    ItemFieldBuilder::build('category_id', $category)
                        ->name('Принадлежит')
                        ->html(
                            self::selectorByField(['1s_category_id'=>$category['1s_category_id']])
                        )
                        ->get()
                )
                ->field(
                    ItemFieldBuilder::build('id', $category)
                        ->name('ID')
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
                                ->addButton()
                                ->get()
                        )
                )
                ->tab(
                    ItemTabBuilder::build('seo')
                        ->html(
                            self::getSeo($category->ownProperties)
                        )

                )
                ->toList('adminsc/category', 'К списку категорий')
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
    public static function categorySelector(Category $category): string
    {
        $tree1 = TreeOptionsBuilder::build(
            CategoryRepository::treeAll(),
            'children_recursive', 2)
            ->initialOption()
            ->selected($category['1s_category_id'])
            ->excluded($category->id)
            ->get();

        return SelectBuilder::build(
            $tree1
        )
            ->field('category_id')
            ->get();

    }

    public static function selectorByField(array $selected, int $excluded = -1): string
    {
        return SelectBuilder::build(
            TreeOptionsBuilder::build(CategoryRepository::treeAll(), 'children_recursive', 2)
                ->initialOption()
                ->selectedByField($selected)
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
                    ->addButton()
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
                ->name('Список запросов')
                ->contenteditable()
                ->relation('ownProperties')
                ->get()->toHtml('product') .
            ItemFieldBuilder::build('seo_h1', $categoryProperty)
                ->name('H 1')
                ->contenteditable()
                ->relation('ownProperties')
                ->get()->toHtml('product') .
//            ItemFieldBuilder::build('seo_h2', $categoryProperty)
//                ->name('H 2')
//                ->contenteditable()
//                ->relation('ownProperties')
//                ->get()->toHtml('product') .
            ItemFieldBuilder::build('seo_path', $categoryProperty)
                ->name('Path')
                ->contenteditable()
                ->relation('ownProperties')
                ->get()->toHtml('product') .
            ItemFieldBuilder::build('seo_article', $categoryProperty)
                ->name('Seo article')
                ->html(self::getSeoArticle($categoryProperty))
                ->id('seo-article')
                ->relation('ownProperties')
                ->get()->toHtml('product') .
            "</div>";

    }

    public static function getSeoArticle($categoryProperty): string
    {
        ob_start();
        include __DIR__ . '/Admin/seoArticle.php';
        return ob_get_clean();
    }

    protected static function getProducts(Category $category): string
    {
        return Table::build($category['products'])
            ->pageTitle('Товары категории')
            ->relation('products', 'product')
            ->addButton()
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


    public static function properties(Collection $properties): string
    {
        $content = Table::build($properties)
            ->pageTitle('Св-ва категории')
            ->relation('properties', 'property')
            ->column(
                ColumnBuilder::build('name')
                    ->name('Наимен')
                    ->contenteditable()
                    ->get()
            )
            ->edit()
            ->addButton()
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