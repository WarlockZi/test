<?php

namespace app\model;

use app\model\Test;
use app\core\Base\Model;
use app\core\App;

class Product extends Model {

   public $table = 'products';

//   public function getProductParents($parentId) {
//
//      if ($parentId) {
//         $sql = 'SELECT * FROM category WHERE id = ?';
//         $params = [$parentId];
//         $parent = $this->findBySql($sql, $params)[0];
//         return $parent;
//      }
//   }
//   public function getProductProps($category) {
//      if (is_array($category)) {
//         $props = [];
//         if (isset($category['parentProps'])) {
//            $props = array_merge($category['parentProps'],$props);
//         }
//         if (isset($category['children']['categories'])) {
//            while ($category['children']['categories']){
//
//               $props = array_merge($category['parentProps'],$props);
//            }
//         }
//
//         return $props;
//      }
//   }

   public function isProduct($url) {

      if ($product = $this->findOne($url, 'alias')) {
         $product['parents'][] = $this->getProductParents($product['parent']);
         while ($last = end($product['parents'])['parent']) {
            $product['parents'][] = $this->getProductParents($last);
         }
         App::$app->cache->set('product' . $url, $product, 30);
      };
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

   public function getProducts($categoryId) {

      $param = [$categoryId];
      $sql = 'SELECT * FROM products WHERE parent = ?';
      $products = $this->findBySql($sql, $param);
      return $products;
   }

   public function getProduct($productId) {

      $param = [$productId];
      $sql = 'SELECT * FROM products WHERE id = ? LIMIT 1';
      $product = $this->findBySql($sql, $param);
      return $product[0];
   }

}
