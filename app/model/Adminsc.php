<?php

namespace app\model;

use app\model\Model;
use app\core\App;

class Adminsc extends Model {

   public function createSiteMap() {

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


}
