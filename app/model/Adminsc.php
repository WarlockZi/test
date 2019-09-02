<?php

namespace app\model;

use app\core\Base\Model;
use app\core\App;

class Adminsc extends Model {

   public function createSiteMap() {

   }
//
//   public function getAllModuls() {
//
//      $sql = "SELECT * FROM instructions WHERE role = ''";
//      exit(json_encode($this->findBySql($sql)));
//   }

//   public function updateProduct($arr) {
//      $param = [$arr["columnValue"], $arr["id"]];
//      $column = $arr["column"];
//      $sql = 'UPDATE products SET '.$column.' = ? WHERE id = ?';
//      $product = $this->findBySql($sql, $param);
//      return $product[0];
//   }
//
//   public function addCatProps($post) {
//
//      $allProps = Prop::getByIds($post['propIds']);
//      $catProps = serialize($allProps);
//      $params = [$catProps, $post['catId']];
//      $sql = "UPDATE category SET prop = ? WHERE id = ?";
//      $this->insertBySql($sql, $params);
//
//      ob_start();
//      require APP . '/view/Adm_catalog/snippet/chooseProp.php';
//      $array['snippet'] = ob_get_clean();
//
//      $array = json_encode($array);
//      exit($array);
//   }

//   public function addPropValue($post) {
//
//      $nextid = $this->autoincrement('vals');
//
//      $sql = "INSERT INTO props (name, parent) VALUES ('', {$post['parentId']})";
//      $this->insertBySql($sql);
//      exit($nextid);
//   }

//   public function getCatProps($arr) {
//
//      $propIdsOnPage = $arr['propIdsOnPage'];
//      $allProps = Prop::getAllWithVals();
//
//      ob_start();
//      require APP . '/view/Adm_catalog/snippet/chooseProp.php';
//      $array['snippet'] = ob_get_clean();
//
//      $array = json_encode($array);
//      exit($array);
//   }

//   public function updatePropName($post) {
//
//      $name = $this->clean_data($post['name']);
//      $id = $this->clean_data($post['id']);
//      $param = [$name, $id];
//      $sql = "UPDATE props SET name = ? WHERE id = ?";
//      return $types = $this->insertBySql($sql, $param);
//   }

//   public function updateProp($post) {
//
//      $val = $this->clean_data($post['val']);
//      $id = $this->clean_data($post['id']);
//
//      $param = [$val, $id];
//      $sql = "UPDATE props SET val = ? WHERE id = ?";
//      return $types = $this->insertBySql($sql, $param);
//   }
//
//   public function addPropBlock($post) {
//      $id = $this->autoincrement('props');
//      $name = $this->clean_data($post['name']);
//      $parent = $this->clean_data($post['parent']);
//      $params = [$name, $parent];
//      $sql = "INSERT INTO props SET name = ?, parent = ?";
//      $add = $this->insertBySql($sql, $params);
//      if ($add) {
//         $block = "
//            <div class='property' data-prop='{$id}'>
//          <div class='prop blue'>
//            <div class='del-prop'>
//              <span>X</span>
//              <span>УДАЛИТЬ</span>
//            </div>{$post['name']}</div>
//                 <div class='val'>
//                          <div class='value' contenteditable='true'></div>
//                  </div>
//          <div class='add-prop-val clear button'>+</div>
//        </div>
//            ";
//      }
//      exit($block);
//   }

//   public function delPropBlock($post) {
//
//      $params = $this->clean_data([$post['id']]);
//      $sql = "DELETE FROM props WHERE id = ?";
//      $del = $this->insertBySql($sql, $params);
//      if ($del) {
//         echo $post['id'];
//      }
//   }

//   public function where($fName = '', $fAct = '', $fArt = '', $prop = []) {
//      $where = ' WHERE ';
//      $and = '';
//      if ($fName) {
//         $where .= " name LIKE ? ";
//         $and = ' and ';
//      }
////      if ($fAct) {
//      $where .= $and . ' act = ?';
//      $and = ' and ';
////      }
//      if ($fArt) {
//         $where .= $and . " art LIKE ?";
//      }
//      return $where;
//   }

//   public function params($fName = '', $fAct = '', $fArt = '', $prop = []) {
//      $params = [];
//
//      if ($fName) {
//         array_push($params, '%' . $fName . '%');
//      }
////      if ($fAct) {
//      array_push($params, $fAct ? 'Y' : 'N');
////      }
//      if ($fArt) {
//         array_push($params, '%' . $fArt . '%');
//      }
//
//      return $params;
//   }

//   public function save($post) {
//
//      $bday = $post->bday;
//      $bday = date("Y-m-d", strtotime($bday));
//      $hired = $post->hired;
//      $hired = date("Y-m-d", strtotime($hired));
//      $fired = $post->fired;
//      $fired = date("Y-m-d", strtotime($fired));
//      $crud = $post->crud;
//
//      $params = [
//          $this->clean_data($post->name),
//          $this->clean_data($post->sName),
//          $this->clean_data($post->mName),
//          $bday,
//          $this->clean_data($post->phone),
//          $post->conf,
//          $this->clean_data($post->email),
//          $this->clean_data($post->rightsStr),
//          $hired,
//          $fired
//      ];
//
//      if ($crud == 'INSERT') {
//         $sql = "
//            INSERT INTO users
//            (name, surName, middleName, birthDate, phone, confirm, email, rightId, hired, fired)
//            VALUES
//            (?,?,?,?,?,?,?,?,?,?)
//            ";
//      } ELSE {
//         array_push($params, $post->userId);
//
//         $sql = "UPDATE users SET "
//            . "name = ?, "
//            . "surName = ?, "
//            . "middleName = ?, "
//            . "birthDate = ?, "
//            . "phone = ?, "
//            . "confirm = ?, "
//            . "email = ?, "
//            . "rightId = ?, "
//            . "hired = ?, "
//            . "fired = ? "
//            . "WHERE id = ?"
//         ;
//      }
//
//      $this->insertBySql($sql, $params);
//   }

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

      $data = (compact('answer'));

      echo $answer; //$json = json_encode($data);
   }

}
