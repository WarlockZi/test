<?php

namespace app\controller;

use app\core\App;

class SearchController extends AppController {

   public function actionIndex() {

      $url = 'alias';

      if (empty($_GET['term']) && empty($_GET['q']))
         exit();

      $q = empty($_GET['q']) ? mb_strtolower($_GET['term']) : mb_strtolower($_GET['q']);
      if (get_magic_quotes_gpc()) {
         $q = stripslashes($q);
      }
      $qSql = addslashes('%' . $q . '%');


      $sql = "SELECT $url, name, preview_pic FROM products WHERE name LIKE ? LIMIT 10";
      $params = [$qSql];
      $arr = App::$app->catalog->findBySql($sql, $params);
//      foreach ($arr as $i => $v){
//         $items[$v['name']] = '/pic'.$v['preview_pic'];
//      }


      $result = array();
      foreach ($arr as $key => $value) {
         if (strpos(mb_strtolower($value['name']), $q) !== false) {
            array_push($result, array(
                'pic' => $value['preview_pic'],
                'url' => $value[$url],
//                'label' => $value['name'],
                'value' => strip_tags($value['name'])));
         }
         if (count($result) > 11)
            break;
      }
      if (empty($_GET['q'])) { // вход не через кнопку
         $this->layout = false;
//        $css = 'vitex.css';
//        $this->set(compact('css'));
         echo json_encode($result);
         exit();
      }else {
         $this->layout = 'vitex';
         $list = App::$app->category->getInitCategories();
         $css = 'vitex.css';
         $this->set(compact('css','list','result'));
      }
   }

}
