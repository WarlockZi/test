<?php


namespace app\view\Category;


use app\model\Category;
use app\model\CategoryProperty;
use app\repository\CategoryRepository;
use app\view\components\Builders\CheckboxBuilder\CheckboxBuilder;
use app\view\components\Builders\ItemBuilder\ItemBuilderNew;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\SelectBuilder\optionBuilders\TreeABuilder;
use app\view\components\Builders\SelectBuilder\optionBuilders\TreeOptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;
use Illuminate\Database\Eloquent\Collection;

class CategoryFormView
{
    public static function edit(Category $category): array
    {
        return ItemBuilderNew::build($category, 'category')
            ->pageTitle('Категория :  ' . ($category->ownProperties->page_title ?? $category->name))
            ->field(
                ItemFieldBuilder::build('name', $category)
                    ->name('Наименование в 1c')
                    ->get()
            )
            ->field(
                ItemFieldBuilder::build('breadcrumbs_name', $category)
                    ->name('Наименование в хлебных крошках')
                    ->data(['relation'=>'ownProperties',
                        'field'=>'breadcrumbs_name'])
                    ->contenteditable()
                    ->html($category->ownProperties->breadcrumbs_name ?? '')
                    ->get()
            )
            ->field(
                ItemFieldBuilder::build('page_title', $category)
                    ->name('Заголовок страницы категории')
                    ->data(['relation'=>'ownProperties',
                        'field'=>'page_title'])
                    ->contenteditable()
                    ->html($category->ownProperties->page_title ?? '')
                    ->get()
            )
            ->field(
                ItemFieldBuilder::build('show_front', $category)
                    ->name('Показывать на главоной')
                    ->checkbox($category->ownProperties?->show_front,['field'=>'show_front', 'relation'=>'ownProperties',] )
//                    ->html(
//                        CheckboxBuilder::build()
//                            ->checked($category->ownProperties?->show_front)
//                            ->data(['field'=>'show_front', 'relation'=>'ownProperties',])
//                            ->get()->toHtml()
//                    )
                    ->get()
            )

            ->field(
                ItemFieldBuilder::build('id', $category)
                    ->name('ID')
                    ->get()
            )
            ->field(
                ItemFieldBuilder::build('s_id', $category)
                    ->name('SID')
                    ->get()
            )
            ->tab(
                ItemTabBuilder::build('Товары категории')
                    ->table(
                        self::products($category)
                    )
            )
            ->tab(
                ItemTabBuilder::build('Св-ва категории')
                    ->table(
                        self::properties($category->properties)
                    )
            )
            ->tab(
                self::getChildCategories($category)
            )
            ->tab(
                ItemTabBuilder::build('seo')
                    ->html(
                        self::getSeo($category->ownProperties)
                    )
            )
            ->toList('adminsc/category', 'К списку категорий')
            ->get();
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
            ->field('category_1s_id')
            ->class('categories')
            ->get();
    }


    public static function selectorByField(array $selected, int $excluded = -1): string
    {
        $t = CategoryRepository::treeAll();

        return SelectBuilder::build(
            TreeOptionsBuilder::build($t, 'children_recursive', 2)
                ->initialOption()
                ->selectedByField($selected)
                ->excluded($excluded)
                ->get()
        )
            ->field('category_1s_id')
            ->class('categories')
            ->get();
    }

//

    public static function getChildCategories(Category $category): ItemTabBuilder
    {
        return ItemTabBuilder::build('Подкатегории')
            ->table(
                Table::build($category['childrenNotDeleted'])
                    ->pageTitle('Подкатегории')
                    ->column(
                        ColumnBuilder::build('id')
                            ->width('40px')
                            ->get()
                    )
                    ->column(
                        ColumnBuilder::build('Назввание')
                            ->callback(function ($cat) {
                                return $cat->name;
                            })
                            ->contenteditable()
                            ->get()
                    )
                    ->data(['relation'=>'childrenNotDeleted', 'model'=>'category'])
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
                ->data(['relation'=>'ownProperties'])
                ->get()->toHtml() .
            ItemFieldBuilder::build('seo_description', $categoryProperty)
                ->name('Description')
                ->contenteditable()
                ->data(['relation'=>'ownProperties'])
                ->get()->toHtml() .
            ItemFieldBuilder::build('seo_keywords', $categoryProperty)
                ->name('Список запросов')
                ->tooltip('keywords для роботов')
                ->contenteditable()
                ->data(['relation'=>'ownProperties'])
                ->get()->toHtml() .
            ItemFieldBuilder::build('seo_h1', $categoryProperty)
                ->name('H 1')
                ->tooltip('используется на странице категории и в статье категории как главный заголовок')
                ->contenteditable()
                ->data(['relation'=>'ownProperties'])
                ->get()->toHtml() .
            ItemFieldBuilder::build('seo_h2', $categoryProperty)
                ->name('H 2')
                ->tooltip('используется в статье категории как второстепенный заголовок')
                ->contenteditable()
                ->data(['relation'=>'ownProperties'])
                ->get()->toHtml() .
            ItemFieldBuilder::build('seo_path', $categoryProperty)
                ->name('Seo путь')
                ->tooltip('используется в адресной строке для поиска категории')
                ->contenteditable()
                ->data(['relation'=>'ownProperties'])
                ->get()->toHtml() .
            ItemFieldBuilder::build('seo_full_name', $categoryProperty)
                ->name('Seo наименование')
                ->tooltip('используется в заголовке категории, например, не опудренные, а Перчатки латексные одинарной хлоринации опудренные в сео desc и keywords')
                ->contenteditable()
                ->data(['relation'=>'ownProperties'])
                ->get()->toHtml() .
            ItemFieldBuilder::build('seo_article', $categoryProperty)
                ->name('Seo article')
                ->html(self::getSeoArticle($categoryProperty))
                ->data(['id'=>'seo-article',
                    'quill'=>'admin'])
                ->data(['relation'=>'ownProperties'])
                ->get()->toHtml() .
            "</div>";

    }

    public static function getSeoArticle($categoryProperty): string
    {
        ob_start();
        include ROOT . '/app/blade/views/admin/category/seoArticle.blade.php';
        return ob_get_clean();
    }

    protected static function products(Category $category): array
    {
        return Table::build($category['products'])
            ->pageTitle('Товары категории')
            ->data(['relation' => 'products', 'model' => 'product'])
            ->addButton()
            ->column(
                ColumnBuilder::build('id')
                    ->emptyRow('0')
                    ->callback(function ($cat) {return $cat->id;})
                    ->width("40px")
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Название')
                    ->callback(function ($p) {
                        return $p->name;
                    })
                      ->headerSearch()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Арт')
                    ->callback(function ($p) {
                        return $p->art;
                    })
                    ->headerSearch()
                    ->width("100px")
                    ->get()
            )
            ->edit()
            ->del()
            ->get();
    }


    public static function properties(Collection $properties): array
    {
        return Table::build($properties)
            ->pageTitle('Св-ва категории')
            ->data(['relation'=>'properties'])
            ->column(
                ColumnBuilder::build('Наимен')
                    ->callback(function ($prop) {
                        return $prop->name;
                    })
                    ->data(['field' => 'name'])
                    ->contenteditable()
                    ->get()
            )

            ->edit()
            ->addButton()
            ->get();
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