<?php

namespace app\model;

use app\core\App;
use app\model\Model;

class Prop extends Model {

   public $table = 'props';

   public static function getPropsVals($props = array()) {
      foreach ($props as $k => $v) {
         $props[$k]['vals'] = App::$app->product->findOneWhere($v, 'parent', 'props');
      };
      return $props;
   }

   public static function getVals($id) {
      return App::$app->product->findOneWhere($id, 'parent', 'props');
   }

   public static function getAll() {

      return App::$app->product->findAll('props');
   }

   public static function getAllWithVals() {
      $props = self::getAll();
      foreach ($props as $key => $value) {
         $props[$key]['vals'] = App::$app->product->findOneWhere($value['id'], 'parent', 'vals');
      }
      return $props;
   }

   public static function getByIds($ids = []) {
      if ($ids) {
         foreach ($ids as $k => $v) {
            $sql = 'SELECT * FROM props WHERE id = ?';
            $params = [$v];
            $props[$k] = App::$app->product->findBySql($sql, $params);
            if ($props[$k]) {
               $props[$k]['vals'] = self::getVals($v);
            }
         }
         return $props;
      }
   }

   public function getProps() {

      $sql = 'SELECT * FROM props';
      $params = [];
      $props = App::$app->prop->findBySql($sql, $params);
      return $props;
   }

}
