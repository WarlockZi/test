<?php

namespace app\model;

use app\model\Test;
use app\core\Base\Model;
use app\core\App;
use app\core\Image;

class Product extends Model {

   public $table = 'products';

   public function updateMainPic($arr) {

      if ($_FILES) {
         $file = $_FILES['file'];
      }
      $name = $arr['alias'];
      $destination = $_SERVER['DOCUMENT_ROOT'] . '/pic/0-' . $name;
      if (!is_dir($destination)) {
         mkdir($destination, 0777, true);
      }
      $filename = $name . '-main.jpg';
      $relativPathToPic = '/0-' .$name.'/'. $filename;
      $to = $destination . '/' . $filename;
      // Перемещаем из tmp папки (прописана в php.config)
      move_uploaded_file($file['tmp_name'], $to);
      $this->resize_photo($destination, $filename, $file['size'], $file['type'], $to);

      $img = new Image($relativPathToPic);
      $sql = 'UPDATE products SET  dpic = ? WHERE id = ?';
      $params = [$relativPathToPic, $arr['pkeyVal']];
      $res = $this->insertBySql($sql, $params);

      exit($to);
//         $params = [$nameHash, $nameRu];
//         $sql = "INSERT INTO pic (nameHash, nameRu) VALUES (?,?)";
//         $this->insertBySql($sql, $params);
   }

   public function getProductParents($parentId) {

      if ($parentId) {
         $sql = 'SELECT * FROM category WHERE id = ?';
         $params = [$parentId];
         $parent = $this->findBySql($sql, $params)[0];
         return $parent;
      }
   }

   public function getSale() {
      $sql = 'SELECT * FROM products WHERE sale = ?';
      $params = [1];
      $products = $this->findBySql($sql, $params);
      return $products;
   }

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

//   public function getProductProps($category) {
//      if (is_array($category)) {
//         $props = [];
//         if (isset($category['parentProps'])) {
//            $props = array_merge($category['parentProps'],$props);
//         }
//         if (isset($category['children']['categories'])) {
//            while ($category['children']['categories']){
//               $props = array_merge($category['parentProps'],$props);
//            }
//         }
//         return $props;
//      }
//   }
}
