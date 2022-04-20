<?php

namespace app\view\widgets\Tree;

use app\model\Model;
use app\core\App;


class Tree extends Model {

   protected $data;
   protected $tree;
   protected $cache = 3600;
   protected $table;


   public function __construct($options = []) {
      $this->getOptions($options);
      $this->run();
   }
    private function getTree($table)
    {
        $res = $table::findAll($table);

        if ($res !== FALSE) {
            $all = [];
            foreach ($res as $key => $v) {
                $all[$v['id']] = $v;
            }
            return $all;
        }
    }
   public function getOptions($options) {
      foreach ($options as $k => $v) {
         if (property_exists($this, $k)) {
            $this->$k = $v;
         }
      }
   }

   protected function run() {

      $this->data = $this->getTree($this->table);
      $this->tree = $this->hierachy();
      $this->menuHTML = $this->getMenuHtml($this->tree);
      $this->output();
   }


   public function getMenuHtml($tree, $tab = ' ') {
      $str = '';
      foreach ($tree as $id => $cat) {
         $str .= $this->catToTemplate($cat, $tab, $id);
      }
      return$str;
   }

   public function catToTemplate($cat, $tab = '', $id = '') {

      ob_start();
      require $this->tpl;
      return ob_get_clean();
   }

   protected function output() {
      echo"<ul class = '{$this->class}'>";
      echo $this->menuHTML;
      echo"</ul>";
   }


}
