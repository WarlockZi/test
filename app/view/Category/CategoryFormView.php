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


    public static function edit(Category $category): array
    {
        return ItemBuilderNew::build($category, 'category')
            ->pageTitle('Категория :  ' . ($category->ownProperties->seo_h1 ?? $category->name))
            ->field(
                ItemFieldBuilder::build('name', $category)
                    ->name('Наименование в 1c')
                    ->get()
            )
            ->field(
                ItemFieldBuilder::build('breadcrumbs_name', $category)
                    ->name('Наименование в хлебных крошках')
                    ->contenteditable()
                    ->html($category->ownProperties->breadcrumbs_name ?? '')
                    ->relation('ownProperties')
                    ->get()
            )
            ->field(
                ItemFieldBuilder::build('show_front', $category)
                    ->name('Показывать на главоной')
                    ->html(
                        CheckboxBuilder::build()
                            ->checkedFn(
                                function ($item) {
                                    return boolval($item->done);
                                }
                            )
                            ->field('show_front')
                            ->get()->toHtml()
                    )
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
                ItemTabBuilder::build('Удаленные Подкатегории')
                    ->table(
                        self::deletedCategories($category)

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

    public static function categorySelector(Category $category): string
    {
        $tree1 = TreeOptionsBuilder::build(
            CategoryRepository::treeAll(),
            'children_recursive', 2)
            ->initialOption()
            ->selected($category['category_1s_id'])
            ->excluded($category->id)
            ->get();

        return SelectBuilder::build(
            $tree1
        )
            ->field('category_1s_id')
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

    public static function productFilterSelector(array $req): string
    {
        $selected = $req['category'] ?? 0;
        return SelectBuilder::build(
            TreeOptionsBuilder::build(CategoryRepository::treeAll(), 'children_recursive', 2)
                ->initialOption()
                ->selected($selected)
                ->get()
        )
            ->field('category_1s_id')
            ->name('category')
            ->class('categories')
            ->get();
    }

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
                ->relation('ownProperties')
                ->get()->toHtml() .
            ItemFieldBuilder::build('seo_description', $categoryProperty)
                ->name('Description')
                ->contenteditable()
                ->relation('ownProperties')
                ->get()->toHtml() .
            ItemFieldBuilder::build('seo_keywords', $categoryProperty)
                ->name('Список запросов')
                ->tooltip('keywords для роботов')
                ->contenteditable()
                ->relation('ownProperties')
                ->get()->toHtml() .
            ItemFieldBuilder::build('seo_h1', $categoryProperty)
                ->name('H 1')
                ->tooltip('используется на странице категории и в статье категории как главный заголовок')
                ->contenteditable()
                ->relation('ownProperties')
                ->get()->toHtml() .
            ItemFieldBuilder::build('seo_h2', $categoryProperty)
                ->name('H 2')
                ->tooltip('используется в статье категории как второстепенный заголовок')
                ->contenteditable()
                ->relation('ownProperties')
                ->get()->toHtml() .
            ItemFieldBuilder::build('seo_path', $categoryProperty)
                ->name('Seo путь')
                ->tooltip('используется в адресной строке для поиска категории')
                ->contenteditable()
                ->relation('ownProperties')
                ->get()->toHtml() .
            ItemFieldBuilder::build('seo_full_name', $categoryProperty)
                ->name('Seo наименование')
                ->tooltip('используется в заголовке категории, например, не опудренные, а Перчатки латексные одинарной хлоринации опудренные в сео desc и keywords')
                ->contenteditable()
                ->relation('ownProperties')
                ->get()->toHtml() .
            ItemFieldBuilder::build('seo_article', $categoryProperty)
                ->name('Seo article')
                ->html(self::getSeoArticle($categoryProperty))
                ->data(['id'=>'seo-article'])
//                ->id('seo-article')
                ->relation('ownProperties')
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
                    ->width("40px")
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Название')
                    ->callback(function ($p) {
                        return $p->name;
                    })
                    ->search()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Арт')
                    ->callback(function ($p) {
                        return $p->art;
                    })
                    ->search()
                    ->width("100px")
                    ->get()
            )
            ->edit()
            ->del()
            ->get();
    }

    public static function deletedCategories(Category $category): array
    {
        return Table::build($category['childrenDeleted'])
            ->pageTitle('Удаленные подкатегории')
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
            ->data(['relation'=>'childrenDeleted', 'model'=>'category'])
            ->edit()
            ->del()
            ->addButton()
            ->get();
    }

    public static function properties(Collection $properties): array
    {
        return Table::build($properties)
            ->pageTitle('Св-ва категории')
            ->data(['relation'=>'properties', 'model'=>'property'])
            ->column(
                ColumnBuilder::build('Наимен')
                    ->callback(function ($prop) {
                        return $prop->name;
                    })
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