<?php

namespace app\model;

use app\core\App;
use app\core\Base\Model;
use app\model\Prop;

class Category extends Model {

   public $table = 'category';

   public function getCategoryParents($parentId, $parents = [], $i = -1) {

      if ($parentId) {
         $sql = 'SELECT * FROM category WHERE id = ?';
         $params = [$parentId];
         $parent = $this->findBySql($sql, $params);
         $parents = array_merge($parents, $parent);
         $i++;
         return $this->getCategoryParents($parents[$i]['parent'], $parents, $i);
      } else {
         return array_reverse($parents);
      }
   }

   public function getAssocCategory() {

      $sql = 'SELECT * FROM category';
      $res = App::$app->category->findBySql($sql, $params = array());

      if ($res !== FALSE) {
         $all = [];
         foreach ($res as $key => $v) {
            $params = [$v['id']];
            $sql = 'SELECT * FROM products WHERE parent = ?';
            $res = App::$app->catalog->findBySql($sql, $params);
            $all[$v['id']] = $v;
            $all[$v['id']]['products'] = $res;
         }

         return $all;
      }
   }

   protected function categoriesTree($cat) {

      $tree = [];
      $data = $cat;
      foreach ($data as $id => &$node) {
         if (isset($node['parent']) && !$node['parent']) {
            $tree[$id] = &$node;
         } elseif (isset($node['parent']) && $node['parent']) {
            $data[$node['parent']]['childs'][$id] = &$node;
         }
      }
      return $tree;
   }

   function findValueByKey($inputArray, $findKey) {
      foreach ($inputArray as $key => $value) {
         if ($findKey == $key) {
            return $value;
         } elseif (is_array($value) && isset($value['childs'])) {
            $tmp = $this->findValueByKey($value['childs'], $findKey);
            if ($tmp !== false) {
               return $tmp;
            }
         }
      }
      return false;
   }

   public function getCategoriesProducts($aCategories, $products = []) {
      foreach ($aCategories as $key => $value) {
         if (isset($value['childs']) && is_array($value['childs'])) {
            $this->getCategoriesProducts($value['childs'], $products);
            $products = array_merge($products, $value['products']);
         }
         $products = array_merge($products, $value['products']);
      }
      return $products;
   }

   public function getCategoryChildren($parentId) {
      $cat = $this->getAssocCategory();
      $tree = $this->categoriesTree($cat);
      $categories = $this->findValueByKey($tree, $parentId);
      if (isset($categories['childs'])) {
         $children['categories'] = $categories['childs'];
         $products = $this->getCategoriesProducts($categories['childs']);
      } else {
         $children['categories'] = [];
         $products = $this->getCategoriesProducts(array($categories));
      }
      $children['products'] = $products;
      return $children;
   }

   public function getCategoryPropertiesSnippet($Id) {

      $sql = 'SELECT * FROM props WHERE parent = ?';
      $params = [$Id];
      $arr['property'] = $this->findBySql($sql, $params);

      ob_start();
      include APP . '/view/Adm_catalog/snippet/KeyVal.php';
      $cont = ob_get_clean();
      return $cont;
   }

   public function isCategory($url) {
      $aCategory = 0;
      if (!$aCategory) {
         $arr = explode('/', $url);
         if (count($arr) > 3) {
            http_response_code(404);
            exit(include '../public/404.html');
         }
         $aCategory = $this->findOne($arr[0], 'alias');
         if ($aCategory && is_array($aCategory)) {
            $aCategory = $aCategory[0];
            $aCategory['parents'] = $this->getCategoryParents($aCategory['parent']);
            $aCategory['children'] = $this->getCategoryChildren($aCategory['id']);
         }
      }
      if (!$aCategory) {
         return FALSE;
      };
      return $aCategory;
   }

   public function getCategory($id) {

      $aCategory = $this->findOne($id);
      if ($aCategory && is_array($aCategory)) {
         $aCategory = $aCategory[0];
         $aCategory['prop'] = explode(',',$aCategory['prop']);
         $aCategory['parents'] = $this->getCategoryParents($aCategory['parent']);
         $aCategory['children'] = $this->getCategoryChildren($aCategory['id']);
      }
      if (!$aCategory) {
         return FALSE;
      };
      return $aCategory;
   }

//   public function getCatPropsValsSnip($catProps) {
//      ob_start();
//      include APP . '/view/Adm_catalog/snippet/KeyVal.php';
//      $cont = ob_get_clean();
//      echo $cont;
//   }

//   public function getProp($prop) {
//      ob_start();
//      include APP . '/view/Adm_settings/snippet/KeyVal.php';
//      $cont = ob_get_clean();
//      echo $cont;
//   }

   public function getInitCategories() {

      $sql = 'SELECT * FROM category WHERE parent = 0';
      $arr = $this->findBySql($sql);
      return $arr;
   }

   function update($arr) {
      $i = 0;
      $set=$values='';
      $params = [];
      $d = count($arr['values']);
      foreach ($arr['values'] as $k=>$v){
         $i++;
         $set .= $k."=?";
         $values .= '?';
         $params[].=$v;
         if(count($arr['values']) > $i) {
            $set.=', ';
            $values.=', ';
         }
      }
          $params[].=(int)$arr['id'];
      $sql = "UPDATE {$arr['model']} SET {$set} WHERE {$arr['field']} = ?";
      $this->insertBySql($sql, $params);
      exit('успешно обновлено!');

   }

}
