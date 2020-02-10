<?php

namespace app\model;

use app\core\Base\Model;
use app\core\App;

class Adminsc extends Model {

   public function createSiteMap() {

   }

   public function where($fName = '', $fAct = '', $fArt = '', $prop = []) {
      $where = ' WHERE ';
      $and = '';
      if ($fName) {
         $where .= " name LIKE ? ";
         $and = ' and ';
      }
//      if ($fAct) {
      $where .= $and . ' act = ?';
      $and = ' and ';
//      }
      if ($fArt) {
         $where .= $and . " art LIKE ?";
      }
      return $where;
   }

   public function params($fName = '', $fAct = '', $fArt = '', $prop = []) {
      $params = [];

      if ($fName) {
         array_push($params, '%' . $fName . '%');
      }
//      if ($fAct) {
      array_push($params, $fAct ? 'Y' : 'N');
//      }
      if ($fArt) {
         array_push($params, '%' . $fArt . '%');
      }

      return $params;
   }



   public function addUser() {

// Следующий id вопроса
      $sql = "SHOW TABLE STATUS FROM vitex_test LIKE 'users'";
      $next = $this->findBySql($sql)[0];
      $uId = $next['Auto_increment'];

      $us = App::$app->user->findAll();
      $rightTypes = App::$app->user->getRightTypes();

      ob_start();
      require APP . '/view/Adminsc/newUser.php';
      $answer = ob_get_clean();

      compact('answer');

      echo $answer;
   }

}
