<?php

namespace app\view\widgets\menu;

use app\core\Base\Model;
use app\core\DB;
use app\core\App;

class Menu extends Model {

   protected $tpl;
   protected $data;
   protected $tree;
   protected $menuHTML;
   protected $class = 'menu';
   protected $cache = 3600;
   protected $sql = "SELECT * FROM test";

   public function __construct($options = []) {
      $this->tpl = __DIR__ . '/menu_tpl/menu.php';
      $this->getOptions($options);
      $this->run();
   }

   public function getOptions($options) {
      foreach ($options as $k => $v) {
         if (property_exists($this, $k)) {
            $this->$k = $v;
         }
      }
   }

   protected function run() {

      $this->data = $this->getAssoc('test');
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
