<?php

namespace app\view\Right;

use app\model\Right;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;
use Illuminate\Database\Eloquent\Model;

class RightView
{

    public $html;



    public static function getCheckList(array $configRights, array $rights, Model $user)
    {
        return include ROOT . '/app/view/User/getRightsTab.php';
    }

}