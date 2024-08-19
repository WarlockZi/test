<?php


namespace app\view\Settings\Admin;


use app\model\Product;
use app\model\Settings;
use app\Repository\ProductRepository;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\CustomList;
use Illuminate\Database\Eloquent\Collection;


class SettingsFormView
{
	public static function edit(Settings $s): string
	{
		return ItemBuilder::build($s, 'settings')
			->pageTitle('Настройки')
			->field(
				ItemFieldBuilder::build('id', $s)
					->name('ID')
					->get()
			)
			->field(
				ItemFieldBuilder::build('name', $s)
					->name('Name')
					->html(
						"<a href='/setting/{$s->name}'>{$s->name}</a>"
					)
					->contenteditable()
					->get()
			)
			->field(
				ItemFieldBuilder::build('title', $s)
					->name('Название')
					->contenteditable()
					->get()
			)
			->field(
				ItemFieldBuilder::build('value', $s)
					->name('Значение')
					->contenteditable()
					->required()
					->get()
			)
			->toList('adminsc/settings/list')

			->get();
	}

	public static function list(Collection $items): string
	{
		return CustomList::build(Settings::class)
			->pageTitle('Настройки')
			->column(
				ListColumnBuilder::build('id')
					->name('ID')
					->get()
			)
			->column(
				ListColumnBuilder::build('name')
					->name('name')
					->contenteditable()
					->search()
					->width('1fr')
					->get()
			)
			->column(
				ListColumnBuilder::build('title')
					->name('Наименование')
					->contenteditable()
					->search()
					->width('1fr')
					->get()
			)
			->column(
				ListColumnBuilder::build('value')
					->name('Значение')
					->contenteditable()
					->search()
					->width('1fr')
					->get()
			)

			->items($items)
			->edit()
			->del()
			->addButton('ajax')
			->get();
	}

}