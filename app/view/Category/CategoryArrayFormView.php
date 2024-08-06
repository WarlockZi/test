<?php


namespace app\view\Category;


use app\core\FS;
use app\model\Category;
use app\model\Product;
use app\Repository\CategoryRepository;
use app\view\components\Builders\CheckboxBuilder\CheckboxBuilder;
use app\view\components\Builders\Dnd\DndBuilder;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;
use app\view\components\Builders\Morph\MorphBuilder;
//use app\view\components\Builders\SelectBuilder\TreeABuilder;
use app\view\components\ItemBuilder\ItemArrayBuilder;
use app\view\components\ItemBuilder\ItemArrayFieldBuilder;
use app\view\components\ItemBuilder\ItemArrayTabBuilder;
use app\view\Image\ImageView;

class CategoryArrayFormView
{
    public static function edit(int $id): string
    {
        $category = CategoryRepository::edit($id);

        return ItemArrayBuilder::build($category, 'category')
            ->pageTitle('Категория :  ' . $category->name)
            ->field(
                ItemArrayFieldBuilder::build('id', $category)
                    ->name('ID')
                    ->get()
            )
            ->field(
                ItemArrayFieldBuilder::build('slug', $category)
                    ->name('Адрес')
                    ->html(
                        "<a href='/category/{$category->slug}'>{$category->slug}</a>"
                    )
                    ->get()
            )
            ->field(
                ItemArrayFieldBuilder::build('name', $category)
                    ->name('Наименование')
                    ->contenteditable()
                    ->required()
                    ->get()
            )
            ->field(
                ItemArrayFieldBuilder::build('show_front', $category)
                    ->name('Показывать на главоной')
                    ->html(
                        CheckboxBuilder::build('show_front',
                            $category->show_front)
                            ->get()
                    )
                    ->get()
            )
            ->field(
                ItemArrayFieldBuilder::build('categiry_id', $category)
                    ->name('Принадлежит')
                    ->html(
                        CategoryRepository::selector1($category->category_id, CategoryRepository::editSelectorExcluded($category))
                    )
                    ->get()
            )
            ->tab(
                ItemArrayTabBuilder::build('Основная картинка')
                    ->html(
                        MorphBuilder::build($category, 'mainImages', 'main')
                            ->html(DndBuilder::make('category'))
                            ->html(ImageView::morphImages($category, 'mainImages'))
                            ->get()
                    )
            )
            ->tab(
                ItemArrayTabBuilder::build('Товары категории')
                    ->html(
                        MyList::build(Product::class)
                            ->pageTitle('Товары категории')
                            ->relation('products')
                            ->addButton('ajax')
                            ->items($category['products'] ?? [])
                            ->column(
                                ListColumnBuilder::build('id')
                                    ->width("40px")
                                    ->get()
                            )
                            ->column(
                                ListColumnBuilder::build('name')
                                    ->name("Название")
                                    ->get()
                            )
                            ->column(
                                ListColumnBuilder::build('art')
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
                ItemArrayTabBuilder::build('Св-ва категории')
                    ->html(
                        self::properties($category)
                    )
            )
            ->tab(
                ItemArrayTabBuilder::build('Подкатегории')
                    ->html(
                        MyList::build(Category::class)
                            ->pageTitle('Подкатегории')
                            ->items($category['childrenNotDeleted'] ?? [])
                            ->column(
                                ListColumnBuilder::build('id')
                                    ->width('40px')
                                    ->get()
                            )
                            ->column(
                                ListColumnBuilder::build('name')
                                    ->name("Назввание")
                                    ->contenteditable()
                                    ->get()
                            )
                            ->relation('childrenNotDeleted')
                            ->edit()
                            ->del()
                            ->addButton('ajax')
                            ->get()
                    )
            )
            ->tab(
                ItemArrayTabBuilder::build('Удаленные Подкатегории')
                    ->html(
                        MyList::build(Category::class)
                            ->pageTitle('Удаленные подкатегории')
                            ->items($category['childrenDeleted'] ?? [])
                            ->column(
                                ListColumnBuilder::build('id')
                                    ->width('40px')
                                    ->get()
                            )
                            ->column(
                                ListColumnBuilder::build('name')
                                    ->name("Назввание")
                                    ->contenteditable()
                                    ->get()
                            )
                            ->relation('childrenDeleted')
                            ->edit()
                            ->del()
                            ->addButton('ajax')
                            ->get()
                    )
            )
            ->toList('adminsc/category/list', 'К списку категорий')
            ->get();
    }

    public static function indexTree()
    {
        $categoriesTree = Category::all();
        return TreeABuilder::build(
            $categoriesTree, 'children_recursive', 2)
            ->href('/adminsc/category/edit/')
            ->get();
    }

    public static function properties($category)
    {
        $fs = new FS(__DIR__.'/Admin');
        $content = $fs->getContent('property', compact('category'));
//        $editIcon = $fs->getContent('properties.php', compact('category'));
//        $delIcon = $fs->getContent('properties.php', compact('category'));
//        $emptyRow = $fs->getContent('properties.php', compact('category'));
//        $propertyRows = $fs->getContent('properties.php', compact('category'));
        return $content;
    }

    public static function list(): string
    {
        return MyList::build(Category::class, 10)
            ->column(
                ListColumnBuilder::build('id')
                    ->get()
            )->column(
                ListColumnBuilder::build('name')
                    ->get()
            )
            ->edit()
            ->get();
    }
}