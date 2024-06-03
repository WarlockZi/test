<?php


namespace app\core;


class ConfigNew
{
  private static $configRights = [
    'user_update'=>'возможность редактировать свой профиль',
    'role_admin'=>"возможность добавлять права другим пользователям, добавлять некоторые свойства и др",
    'role_employee'=>'возможность заходить в админку, проходить тесты, смотреть обучающие видео',
    'test_delete'=>'возможность удалять тесты',
  ];

  public static function getConfigRights()
  {
    return self::$configRights;
  }

}