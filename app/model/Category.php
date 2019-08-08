<?php

namespace app\model;

use app\core\App;
use app\core\Base\Model;
use app\model\Prop;

class Category extends Model {

   public $table = 'category';

   public function getCategoryParents($parentId, $parents = []) {

      if ($parentId) {
         $sql = 'SELECT * FROM category WHERE id = ?';
         $params = [$parentId];
         $parents[] = $this->findBySql($sql, $params)[0];

         return $parents;
      }
      return array();
   }

   public function mergeArrays($children, $catId) {

      $sql = 'SELECT * FROM products WHERE parent = ?';
      $params = [$catId];
      $products = $this->findBySql($sql, $params);

      if (!isset($children['products'])) {
         $children['products'] = [];
      }
      $exisingProducts = $children['products'];

      $combinedProducts = array_merge(
         $products, $exisingProducts
      );
      return $combinedProducts;
   }

   public function getCategoryChildren($parentId, $children) {

      $sql = 'SELECT * FROM category WHERE parent = ?';
      $params = [$parentId];
      if (!isset($children['categories'])) {
         $children['categories'] = $this->findBySql($sql, $params);
      }
// найдем продукты категории
      $children['products'] = $this->mergeArrays($children, $parentId);
      foreach ($children['categories'] as $key => $value) {
// найдем продукты ребенка
         $children['products'] = $this->mergeArrays($children, $value['id']);
// найдем детей ребенка
         $sql = 'SELECT * FROM category WHERE parent = ?';
         $params = [$value['id']];
         if ($this->findBySql($sql, $params)) {
            getCategoryChildren($value['id'], $children);
         }
      }

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

   public function getCategory($id) {
      $category = App::$app->cache->get('category'.$url);
if(!$category){ 

         if ($category = $this->findOne($id)[0]) {
            $category['parents'] = $this->getCategoryParents($category['parent']);
            $category['children'] = $this->getCategoryChildren($category['id']);
            App::$app->cache->set('category' . $url, $category, 30);
         }
}
      if (!$category) {
         return FALSE;
      };
      return $category;
   }
   public function getCategoryByUrl($url) {

//      $category = App::$app->cache->get('category'.$url);
      if (!$category) {
         $arr = explode('/', $url);
         if (count($arr) > 3) {
            http_response_code(404);
            exit(include '../public/404.html');
         }
         if ($category = $this->findOne($arr[0], 'alias')[0]) {
            $category['parents'] = $this->getCategoryParents($category['parent']);
            $category['children'] = $this->getCategoryChildren($category['id']);
            App::$app->cache->set('category' . $url, $category, 30);
         }
      }
      if (!$category) {
         return FALSE;
      };
      return $category;
   }

   /**
    * Получить категории, у которых нет родителей
    * */
   public function getInitCategories() {

      $sql = 'SELECT * FROM category WHERE parent = 0';
      $arr = $this->findBySql($sql);
      return $arr;
   }

}
