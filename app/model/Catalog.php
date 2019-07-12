<?php

namespace app\model;

use app\model\Test;
use app\core\Base\Model;

class Catalog extends Model {

   public $table = 'products';


   public function isProduct($url) {
      
      
      //      $category = App::$app->cache->get('category'.$url);
      if (!$product) {
         $arr = explode('/', $url);
         if (count($arr) > 3) {
            http_response_code(404);
            exit(include '../public/404.html');
         }
         
         
         if ($product = $this->findOne($arr[0], 'name')[0]) {
            $product['parents'] = $this->getCategoryParents($product['parent']);
            $product['children'] = $this->getCategoryChildren($product['id']);
            App::$app->cache->set('category' . $url, $product, 30);
         }
      }
      if (!$product) {
         return FALSE;
      };
      return $product;
   }
   
   public function productsCnt() {

      $sql = 'SELECT COUNT(*) FROM PRODUCTS';
      $arr = $this->findBySql($sql)[0];
      return $arr['COUNT(*)'];
   }

//   public function getCatChildren($id) {
//      // получим детей
//      $sql = 'SELECT * FROM category WHERE parent = ?';
//      $params = [$id];
//      return $this->findBySql($sql, $params);
//   }

//   public function getCategory($id) {
//      $sql = 'SELECT * FROM category WHERE id = ?';
//      $params = [$id];
//      return $this->findBySql($sql, $params);
//   }

//   public function getCategoryParents($parentId) {
//// получим родителей
//      $i = 0;
//      while ($parentId) {
//         $i++;
//         $sql = 'SELECT parent,alias FROM category WHERE id = ?';
//         $params = [$arr['parent']];
//         $parent = $this->findBySql($sql, $params)[0];
//         $arr['parents'][$i]['name'] = $parent['alias'];
//         $arr['parents'][$i]['id'] = $arr['parent'];
//         $parentId = (int) $parent['parent'];
//      }
//      return $arr;
//   }



   public function getProducts($categoryId) {

      $param = [$categoryId];
      $sql = 'SELECT * FROM products WHERE parent = ?';
      $products = $this->findBySql($sql, $param);
      return $products;
   }

   public function getProduct($productId) {

      $param = [$productId];
      $sql = 'SELECT * FROM products WHERE id = ?';
      $product = $this->findBySql($sql, $param);
      return $product[0];
   }

}
