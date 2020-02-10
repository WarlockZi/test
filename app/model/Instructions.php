<?php

namespace app\model;

use app\core\Base\Model;

class Instructions extends Model {

   public $table = 'instructions';

   /**
    * Получить категории, у которых нет родителей
    * */
   public function getDoc($role) {

      $params = [$role];
      $sql = 'SELECT * FROM instructions WHERE role = ?';
      $arr = $this->findBySql($sql, $params);
      return $arr;
   }

   public function getAllModuls() {

      $sql = "SELECT * FROM instructions WHERE role = ''";
      return $this->findBySql($sql);
   }

}
