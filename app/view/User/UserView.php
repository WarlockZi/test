<?php


namespace app\view\User;


use app\model\User;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;


use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\components\CustomCatalogItem\CustomCatalogItem;
use app\view\components\CustomDate\CustomDate;
use app\view\components\CustomRadio\CustomRadio;
use app\view\components\CustomSelect\CustomSelect;
use app\view\MyView;


abstract class UserView extends MyView
{

	public $model;
	public $html;


	public static function getAdminTab($user)
	{
		if (is_string($user['rights'])){
			$user['rights'] = explode(',',$user['rights']);
		}
		return ItemTabBuilder::build("Права")
			->html(self::getRights($user))
			->field('rights')
			->get();
	}

	public static function guest($item)
	{
		$userArr = $item->toArray();
		return ItemBuilder::build($item, 'user')
			->pageTitle('Редактировать пользователя: ' . $item->fi())
			->save()
			->field(
				ItemFieldBuilder::build('id', $item)
					->name('ID')
					->get()
			)
			->field(
				ItemFieldBuilder::build('email', $item)
					->get()
			)
			->field(
				ItemFieldBuilder::build('surName', $item)
					->name('Фамилия')
					->contenteditable()
					->get()
			)
			->field(
				ItemFieldBuilder::build('name', $item)
					->name('Имя')
					->contenteditable()
					->get()
			)
			->field(
				ItemFieldBuilder::build('middleName', $item)
					->name('Отчество')
					->contenteditable()
					->get()
			)
			->field(
				ItemFieldBuilder::build('phone', $item)
					->name('Телефон')
					->contenteditable()
					->get()
			)
			->field(
				ItemFieldBuilder::build('birthDate', $item)
					->name('Дата рождения')
					->html(
						self::getBirhtdate($userArr)
					)
					->get()
			)

			->field(
				ItemFieldBuilder::build('sex', $item)
					->name('Пол')
					->html(
						self::getSex($userArr)
					)
					->get()
			)
			->get();
	}

	public static function employee($item)
	{
		$userArr = $item->toArray();
		$userArr['rights'] = explode(',', $userArr['rights']);

		return ItemBuilder::build($item, 'user')
			->pageTitle('Редактировать пользователя: ' . $item['surName'] . ' ' . $item['name'])
			->toList()
			->save()
			->del()

			->field(
				ItemFieldBuilder::build('id', $item)
					->name('ID')
					->get()
			)
			->field(
				ItemFieldBuilder::build('email', $item)
					->get()
			)
			->field(
				ItemFieldBuilder::build('surName', $item)
					->name('Фамилия')
					->contenteditable()
					->get()
			)
			->field(
				ItemFieldBuilder::build('name', $item)
					->name('Имя')
					->contenteditable()
					->get()
			)
			->field(
				ItemFieldBuilder::build('middleName', $item)
					->name('Отчество')
					->contenteditable()
					->get()
			)
			->field(
				ItemFieldBuilder::build('phone', $item)
					->name('Телефон')
					->contenteditable()
					->get()
			)
			->field(
				ItemFieldBuilder::build('birthDate', $item)
					->name('Дата рождения')
					->html(
						self::getBirhtdate($item)
					)
					->get()
			)
			->field(
				ItemFieldBuilder::build('birthDate', $item)
					->name('Дата рождения')
					->html(
						self::getBirhtdate($item)
					)
					->get()
			)
			->field(
				ItemFieldBuilder::build('sex', $item)
					->name('Пол')
					->html(
						self::getSex($userArr)
					)
					->get()
			)
			->get();
	}

	public static function admin($item)
	{
		$userArr = $item->toArray();
		return ItemBuilder::build($item, 'user')
			->pageTitle('Редактировать пользователя: ' . $item['surName'] . ' ' . $item['name'])
			->toList()
			->save()
			->del()
			->tab(UserView::getAdminTab($userArr))
			->field(
				ItemFieldBuilder::build('id', $item)
					->name('ID')
					->get()
			)
			->field(
				ItemFieldBuilder::build('email', $item)
					->get()
			)
			->field(
				ItemFieldBuilder::build('surName', $item)
					->name('Фамилия')
					->contenteditable()
					->get()
			)
			->field(
				ItemFieldBuilder::build('name', $item)
					->name('Имя')
					->contenteditable()
					->get()
			)
			->field(
				ItemFieldBuilder::build('middleName', $item)
					->name('Отчество')
					->contenteditable()
					->get()
			)
			->field(
				ItemFieldBuilder::build('phone', $item)
					->name('Телефон')
					->contenteditable()
					->get()
			)
			->field(
				ItemFieldBuilder::build('birthDate', $item)
					->name('Дата рождения')
					->html(
						self::getBirhtdate($item)
					)
					->get()
			)
			->field(
				ItemFieldBuilder::build('birthDate', $item)
					->name('Дата рождения')
					->html(
						self::getBirhtdate($item)
					)
					->get()
			)
			->field(
				ItemFieldBuilder::build('sex', $item)
					->name('Пол')
					->html(
						self::getSex($userArr)
					)
					->get()
			)
			->field(ItemFieldBuilder::build('hired', $item)
				->name('Принят')
				->html(
					self::getHiredHtml($item)
				)
				->get())
			->field(ItemFieldBuilder::build('fired', $item)
				->name('Уволен')
				->html(
					self::getFiredHtml($item)
				)
				->get())
			->field(
				ItemFieldBuilder::build('confirmed', $item)
					->name('Подтвержден')
					->html(
						self::getConfirmHtml($item)
					)
					->get())
			->get();

	}

	public static function listAll(): string
	{
		return MyList::build(User::class)
			->column(
				ListColumnBuilder::build('id')
					->name('ID')
					->get())
			->column(
				ListColumnBuilder::build('name')
					->name('Имя')
					->search()
					->width('1fr')
					->get())
			->column(
				ListColumnBuilder::build('surName')
					->name('Фамилия')
					->search()
					->width('1fr')
					->get())
			->column(
				ListColumnBuilder::build('confirm')
					->name('co')
					->get())
			->edit()
			->all()
			->get();
	}


	public static function getRights($user)
	{
		$rights = \app\model\Right::findAll();
		return include ROOT . '/app/view/User/getRightsTab.php';
	}


	public static function getSex(array $item)
	{
		return SelectBuilder::build()
			->model('user')
			->field('sex')
			->nameOptionByField('name')
			->array(['m' => 'М', 'f' => 'Ж'])
			->selected($item['sex'])
			->get();
	}

	public static function getBirhtdate($user)
	{
		$birthDate = new CustomDate([
			'className' => 'bdate',
			'title' => '',
			'field' => 'birthDate',
			'min' => '1965-01-01',
			'max' => date('Y-m-d'),
			'value' => $user['birthDate'],
		]);
		return $birthDate->html;
	}

	public static function getHiredHtml($user)
	{
		$hired = new CustomDate([
			'className' => 'hired',
			'field' => 'hired',
			'min' => '1965-01-01',
			'max' => '2025-01-01',
			'value' => $user['hired'],
		]);
		return $hired->html;
	}

	public static function getFiredHtml($user)
	{
		$fired = new CustomDate([
			'className' => 'fired',
			'field' => 'fired',
			'min' => '1965-01-01',
			'max' => '2025-01-01',
			'value' => $user['fired'],
		]);
		return $fired->html;
	}

	public static function getConfirmRow($item)
	{
		$html = self::getConfirmHtml($item);
		return [
			'Подтвержден' => [
				'field' => 'Подтвержден',
				'contenteditable' => false,
				'data-type' => 'select',
				'html' => $html,
			]
		];
	}

	public static function getHiredRow($item)
	{
		$html = self::getHiredHtml($item);
		return [
			'hired' => [
				'className' => 'fired',
				'field' => 'hired',
				'name' => 'Принят в штат',
				'contenteditable' => true,
				'data-type' => 'date',
				'html' => $html,
			]
		];
	}

	public static function getFiredRow($item)
	{
		$html = self::getFiredHtml($item);
		return [
			'fired' => [
				'className' => 'fired',
				'field' => 'fired',
				'name' => 'Уволен',
				'contenteditable' => true,
				'data-type' => 'date',
				'html' => $html,
			],
		];
	}

	public static function getConfirmHtml($item)
	{
//		$confirm = new CustomSelect([
//			'selectClassName' => 'custom-select',
//			'title' => '',
//			'field' => 'confirm',
//			'tab' => '&nbsp;&nbsp;&nbsp;',
//			'tree' => [1 => 'да', 0 => 'нет'],
//			'selected' => [$item['confirm'] ?? 0],
//		]);

		return SelectBuilder::build()
			->model('user')
			->field('confirm')
			->nameOptionByField('name')
			->array([1 => 'да', 0 => 'нет'])
			->selected($item['confirm'] ?? 0)
			->get();
	}

	public static function noElement()
	{
		return
			"<div class='no-element'>Элемент не найден" .
			"<a class='to-list' href='/adminsc/user/list\'>К списку</a>" .
			"</div>";
	}


}