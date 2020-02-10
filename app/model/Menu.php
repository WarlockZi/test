<?php

namespace app\model;

use app\core\Base\Model;

class Menu extends Model {

// Для какой страницы надо    
   public $page = 'test';

   public function __construct($page) {
      if ($page) {
         $this->page = $page;
      }
   }

}
