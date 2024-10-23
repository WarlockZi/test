<?php

namespace app\Services\AdminSidebar;

use app\core\Icon;
use app\model\User;

class AdminSidebar
{
    private User $user;
    private array $sidebar;

    public static function build(User $user): string
    {
        $self          = new self();
        $self->user    = $user;
        $self->sidebar = $self->sidebar();
        ob_start();
        foreach ($self->sidebar as $item) {
            if ($item['children']) {
                if ($item['permissions']) {
                    if ($self->user->can($item['permissions'])) {
                        echo $self->ul($item);
                    }
                } else {
                    echo $self->ul($item);
                }
            } else {
                if ($item['permissions']) {
                    if ($self->user->can($item['permissions'])) {
                        echo $self->a($item);
                    }
                } else {
                    echo $self->a($item);
                }
            }
        }
        return ob_get_clean();

    }

    private function a(array $item): void
    {
        $f = ROOT . "/app/Services/AdminSidebar/a.php";
        include($f);
    }

    private function ul(array $item): void
    {
        $f = ROOT . "/app/Services/AdminSidebar/ul.php";
        include $f;
    }

    private function child(array $item): void
    {
        $f = ROOT . "/app/Services/AdminSidebar/child.php";
        if ($item['permissions']) {
            if ($this->user->can($item['permissions'])) {
                include $f;
            }
        } else {
            include $f;
        }
    }

    private function sidebar(): array
    {
        return [
            [
                "name" => "Галвная",
                "icon" => Icon::house('admin-menu'),
                "href" => "/adminsc",
                "class" => "house neon",
                "permissions" => [],
                "children" => null,
            ],
            [
                "name" => "CRM",
                "icon" => Icon::chart('admin-menu'),
                "href" => null,
                "class" => null,
                "permissions" => ['role_admin', 'role_manager'],
                "children" => [
                    [
                        "name" => "Предложения сайт",
                        "href" => "/adminsc/wish",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Заказы",
                        "href" => "/adminsc/order",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Пользователи",
                        "href" => "/adminsc/user",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "crm",
                        "href" => "/adminsc/crm",
                        "class" => "neon",
                        "permissions" => [],
                    ], [
                        "name" => "Акции",
                        "href" => "/adminsc/promotion",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                ],
            ],
            [
                "name" => "Настройки",
                "icon" => Icon::settingsStreamline('admin-menu'),
                "href" => null,
                "class" => null,
                "permissions" => ['role_admin'],
                "children" => [
                    [
                        "name" => "Свойства",
                        "href" => "/adminsc/property",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Права",
                        "href" => "/adminsc/right",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Страны",
                        "href" => "/adminsc/country",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Производители",
                        "href" => "/adminsc/manufacturer",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Tэги",
                        "href" => "/adminsc/tag",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Ед. измерен.",
                        "href" => "/adminsc/unit",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Картинки",
                        "href" => "/adminsc/image",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Должности",
                        "href" => "/adminsc/post",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Задачи",
                        "href" => "//adminsc/planning",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                ],
            ],
            [
                "name" => "Видео",
                "icon" => Icon::youtube(),
                "href" => null,
                "class" => null,
                "permissions" => ['role_employee'],
                "children" => [
                    [
                        "name" => "Инструкции",
                        "href" => "/adminsc/videoinstruction",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Редактировать",
                        "href" => "/adminsc/videoinstruction/edit",
                        "class" => "neon",
                        "permissions" => ['role_admin'],
                    ],
                ],
            ],
            [
                "name" => "Тесты",
                "icon" => Icon::star('admin-menu'),
                "href" => null,
                "class" => null,
                "permissions" => ['role_employee'],
                "children" => [
                    [
                        "name" => "Проходить тесты",
                        "href" => "/adminsc/test/do",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Редактировать тесты",
                        "href" => "/adminsc/test/edit",
                        "class" => "neon",
                        "permissions" => ['role_admin'],
                    ],
                    [
                        "name" => "Результаты тестов",
                        "href" => "/adminsc/testresult",
                        "class" => "neon",
                        "permissions" => ['role_admin'],
                    ],
                    [
                        "name" => "Проходить открытые тесты",
                        "href" => "/adminsc/opentest/do",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Редактировать открытые тесты",
                        "href" => "/adminsc/opentest/edit",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Результаты открытых тестов",
                        "href" => "/adminsc/opentestresult",
                        "class" => "neon",
                        "permissions" => ['role_admin'],
                    ],
                ],
            ],
            [
                "name" => "Планирование",
                "icon" => Icon::flag('admin-menu'),
                "href" => null,
                "class" => null,
                "permissions" => ['role_employee'],
                "children" => [
                    [
                        "name" => "Создать задачи",
                        "href" => "/adminsc/planning/create",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Посмотреть планировки",
                        "href" => "/adminsc/planning/list",
                        "class" => "neon",
                        "permissions" => ['role_admin'],
                    ],
                    [
                        "name" => "Спланироваться",
                        "href" => "/adminsc/planning/plan",
                        "class" => "neon",
                        "permissions" => ['role_admin'],
                    ],
                    [
                        "name" => "Циклограмма",
                        "href" => "/adminsc/cicles",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                ],
            ],

            [
                "name" => "Отчеты",
                "icon" => Icon::target('admin-menu'),
                "href" => null,
                "class" => null,
                "permissions" => ['role_employee'],
                "children" => [
                    [
                        "name" => "Фильтры",
                        "href" => "/adminsc/report/filter",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                ],
            ],
            [
                "name" => "Планирование",
                "icon" => Icon::flag('admin-menu'),
                "href" => null,
                "class" => null,
                "permissions" => ['role_employee'],
                "children" => [
                    [
                        "name" => "Создать задачи",
                        "href" => "/adminsc/planning/create",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Посмотреть планировки",
                        "href" => "/adminsc/planning/list",
                        "class" => "neon",
                        "permissions" => ['role_admin'],
                    ],
                    [
                        "name" => "Спланироваться",
                        "href" => "/adminsc/planning/plan",
                        "class" => "neon",
                        "permissions" => ['role_admin'],
                    ],
                    [
                        "name" => "Циклограмма",
                        "href" => "/adminsc/cicles",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                ],
            ],
            [
                "name" => "Страт задачи",
                "icon" => Icon::grid('admin-menu'),
                "href" => "/adminsc/planning",
                "class" => null,
                "permissions" => ['role_employee'],
                "children" => [],
            ],
            [
                "name" => "Каталог",
                "icon" => Icon::shoppingCart('feather'),
                "href" => null,
                "class" => null,
                "permissions" => ['role_admin'],
                "children" => [
                    [
                        "name" => "Категории",
                        "href" => "/adminsc/category",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                ],
            ],
            [
                "name" => "Пользователь",
                "icon" => Icon::userCheck('admin-menu'),
                "href" => null,
                "class" => null,
                "permissions" => [],
                "children" => [
                    [
                        "name" => "Забыл пароль",
                        "href" => "/auth/returnpass",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Сменить пароль",
                        "href" => "/auth/changepassword",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Изменить свой профиль",
                        "href" => "/auth/profile",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Выйти",
                        "href" => "/auth/logout",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                ],
            ],
            [
                "name" => "SU",
                "icon" => Icon::aperture('admin-menu'),
                "href" => null,
                "class" => null,
                "permissions" => ['su'],
                "children" => [
                    [
                        "name" => "Логистика",
                        "href" => "/adminsc/logistic",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Настройки",
                        "href" => "/adminsc/settings/list",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Создать SiteMap",
                        "href" => "/adminsc/Sitemap",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "test",
                        "href" => "/adminsc/request/test",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "PHPinfo",
                        "href" => "/adminsc/request/phpinfo",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Запросы",
                        "href" => "/adminsc/request",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "1c Sync",
                        "href" => "/adminsc/sync",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Очистить кэш",
                        "href" => "adminsc/settings/cache",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Свойства (товаров, пользователей)",
                        "href" => "/adminsc/settings/props",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                    [
                        "name" => "Dump",
                        "href" => "/adminsc/settings/dump'",
                        "class" => "neon",
                        "permissions" => [],
                    ],
                ],
            ],
        ];
    }
}