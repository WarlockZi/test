<?php


namespace app\view\UserYandex;


use app\core\ConfigNew;
use app\model\Right;
use app\model\Role;
use app\model\User;
use app\model\UserYandex;
use app\view\components\Builders\Date\DateBuilder;
use app\view\components\Builders\ItemBuilder\ItemBuilder;
use app\view\components\Builders\ItemBuilder\ItemFieldBuilder;
use app\view\components\Builders\ItemBuilder\ItemTabBuilder;
use app\view\components\Builders\SelectBuilder\optionBuilders\ArrayOptionsBuilder;
use app\view\components\Builders\SelectBuilder\SelectBuilder;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;
use app\view\Right\RightView;
use Illuminate\Database\Eloquent\Model;


abstract class UserYandexView
{
    public static function getViewByRole(Model $userToEdit, $thisUser): string
    {
        if (!$userToEdit) return '';
        if ($thisUser->can(['role_employee'])) {
            if ($thisUser->can(['role_admin'])) {
                return self::admin($userToEdit);
            }
            return self::employee($userToEdit);
        }
        return self::guest($userToEdit);
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
        return $item
            ? ItemBuilder::build($item, 'user')
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
                ->get()
            : "Вы не зарегистрировались";
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
            ->toList('adminsc/useryandex', 'К списку')
            ->tab(self::getAdminTab($item))
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
        $userY = UserYandex::with('role')->get();
        return Table::build($userY)
            ->pageTitle('Пользователи Yandex')
            ->model('userYandex')
            ->column(
                ColumnBuilder::build('id')
                    ->name('ID')
                    ->get())
            ->column(
                ColumnBuilder::build('last_name')
                    ->name('Фамилия')
                    ->search()
                    ->width('1fr')
                    ->get())
            ->column(
                ColumnBuilder::build('first_name')
                    ->name('Имя')
                    ->search()
                    ->width('1fr')
                    ->get())
            ->column(
                ColumnBuilder::build('default_email')
                    ->name('email')
                    ->search()
                    ->width('1fr')
                    ->get())
            ->column(
                ColumnBuilder::build('default_phone')
                    ->name('phone')
                    ->callback(function ($userY){
                        $obj = json_decode($userY->default_phone);
                        return $obj->number;
                    })
                    ->search()
                    ->width('1fr')
                    ->get())
            ->column(
                ColumnBuilder::build('role')
                    ->name('роль')
                    ->width('1fr')
                    ->callback(function ($user) {
                        return self::roleSelector($user);
                    })
                    ->get())
            ->edit()
            ->del()
            ->get();
    }

    protected static function roleSelector(UserYandex $user): string
    {
        $selected = $user->role->first()->id ?? 0;
        return SelectBuilder::build(
            ArrayOptionsBuilder::build(Role::all())
                ->initialOption()
                ->selected($selected)
                ->get())
            ->relation('role', 'roleUserYandex')
//            ->field('user_yandex_id')
            ->get();
    }

    public static function getRights(UserYandex $user)
    {
        $configRights = ConfigNew::getConfigRights();
        $rights       = Right::all()->toArray();
        return RightView::getCheckList($configRights, $rights, $user);
    }


    public static function getSex(UserYandex $item)
    {
        $options = ArrayOptionsBuilder::build([
            ['id' => 'm', 'name' => 'М'],
            ['id' => 'f', 'name' => 'Ж']
        ])
            ->selected((int)$item->sex)
            ->get();

        return SelectBuilder::build($options)
            ->field('sex')
            ->get();
    }

    public static function getBirhtdate(UserYandex $user): string
    {
        return DateBuilder::build($user->birthDate)
            ->field('birthDate')
            ->get();
    }

    public static function getHiredHtml($user): string
    {
        return DateBuilder::build($user['hired'])
            ->field('hired')
            ->min('2024-01-01')
            ->max('2025-01-01')
            ->get();
    }

    public static function getFiredHtml($user): string
    {
        return DateBuilder::build($user['fired'])
            ->field('fired')
            ->min('2024-01-01')
            ->max('2025-01-01')
            ->get();
    }


    public static function getConfirmHtml($item): string
    {
        $options = ArrayOptionsBuilder::build([
            ['id' => 0, 'name' => 'нет'],
            ['id' => 1, 'name' => 'да'],
        ])->selected((int)$item['confirm'] ?? 0)
            ->get();

        return SelectBuilder::build($options)
            ->field('confirm')
            ->get();
    }

}