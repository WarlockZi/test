<?php


namespace app\view\User;


use app\core\ConfigNew;
use app\model\Right;
use app\model\User;
use app\view\components\Builders\Date\DateBuilder;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\SelectBuilder\optionBuilders\ArrayOptionsBuilder;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\Right\RightView;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


abstract class UserView
{

	public $model;
	public $html;

	public static function getViewByRole(Model $userToEdit, $thisUser): string
    {
		if ($userToEdit) {
			if ($thisUser->can(['role_employee'])) {
				if ($thisUser->can(['role_admin'])) {
					return UserView::admin($userToEdit);
				}
				return UserView::employee($userToEdit);
			} else {
				return UserView::guest($userToEdit);
			}
		}
		return UserView::noElement();
	}

	public static function getAdminTab(Model $user): ItemTabBuilder
    {
		if (is_string($user->rights)) {
			$user->rights = explode(',', $user->rights);
		}
		return ItemTabBuilder::build("Права")
			->html(self::getRights($user));
	}

	public static function guest($item): string
    {
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
						self::getBirhtdate($item)
					)
					->get()
			)
			->field(
				ItemFieldBuilder::build('sex', $item)
					->name('Пол')
					->html(
						self::getSex($item)
					)
					->get()
			)
			->get();
	}

	public static function employee($item): string
    {
		return ItemBuilder::build($item, 'user')
			->pageTitle('Редактировать пользователя: ' . $item['surName'] . ' ' . $item['name'])
			->toList('adminsc/user/table', '', false)
			->save()
			->del(false)
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
				ItemFieldBuilder::build('sex', $item)
					->name('Пол')
					->html(
						self::getSex($item)
					)
					->get()
			)
			->get();
	}

	public static function admin(User $item): string
    {

		return ItemBuilder::build($item, 'user')
			->pageTitle('Редактировать пользователя: ' . $item['surName'] . ' ' . $item['name'])
			->toList('adminsc/user/table')
			->save()
			->del()
			->tab(UserView::getAdminTab($item))
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
				ItemFieldBuilder::build('sex', $item)
					->name('Пол')
					->html(
						self::getSex($item)
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
		return Table::build(User::all())
            ->model('user')
			->column(
				ColumnBuilder::build('id')
					->name('ID')
					->get())
			->column(
				ColumnBuilder::build('name')
					->name('Имя')
					->search()
					->width('1fr')
					->get())
			->column(
				ColumnBuilder::build('surName')
					->name('Фамилия')
					->search()
					->width('1fr')
					->get())
			->column(
				ColumnBuilder::build('confirm')
					->name('co')
					->get())
			->edit()
			->del()
			->get();
	}


	public static function getRights(Model $user)
	{
		$configRights = ConfigNew::getConfigRights();
		$rights = Right::all()->toArray();
		return RightView::getCheckList($configRights, $rights, $user);
	}


	public static function getSex(Model $item)
	{
		$options = ArrayOptionsBuilder::build(new Collection([
			0 => ['id' => 'm', 'name' => 'М'],
			1 => ['id' => 'f', 'name' => 'Ж']
		]))
			->selected((int)$item->sex)
			->get();

		return SelectBuilder::build($options)
			->field('sex')
			->get();
	}

	public static function getBirhtdate(Model $user): string
    {
		return DateBuilder::build($user->birthDate)
			->field('birthDate')
			->get();
	}

	public static function getHiredHtml($user)
	{
		return DateBuilder::build($user['hired'])
			->field('hired')
			->min('1965-01-01')
			->max('2025-01-01')
			->get();
	}

	public static function getFiredHtml($user)
	{
		return DateBuilder::build($user['fired'])
			->field('fired')
			->min('1965-01-01')
			->max('2025-01-01')
			->get();
	}


	public static function getConfirmHtml($item)
	{
		$options = ArrayOptionsBuilder::build(new Collection(				[
			0 => ['id' => 0, 'name' => 'нет'],
			1 => ['id' => 1, 'name' => 'да'],
		]))->selected((int)$item['confirm'] ?? 0)
			->get();

		return SelectBuilder::build($options)
			->field('confirm')
			->get();
	}

	public static function noElement()
	{
		return
			"<div class='no-element'>Элемент не найден" .
			"<a class='to-table' href='/adminsc/user'>К списку</a>" .
			"</div>";
	}


}