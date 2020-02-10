<?php

namespace app\view\widgets\pagination;

use app\core\Base\Model;
use app\core\DB;
use app\model\Test;

class Pagination extends Model {

  protected $id;
  protected $testData;
  protected $tpl;
  protected $class = 'pagination';
  protected $cache = 3600;
  protected $sql = "SELECT * FROM test";

  public function __construct($options = []) {
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

    $testId = $this->id;

    $count_questions = count($this->testData);
    $keys = array_keys($this->testData);

    $pagination = '<div class="pagination">';
    for ($i = 1; $i <= $count_questions; $i++) {
      // Убираем ключи, оставляем только значения
      $key = array_shift($keys);
      if ($i == 1) {
        $pagination .= '<a href="#question-' . $this->testData[$i-1]['id'] . '" class="nav-active"><div>' . $i . '</div></a>';
      } else {
        $pagination .= '<a href="#question-' . $this->testData[$i-1]['id'] . '" class = "p-no-active" ><div>' . $i . '</div></a>';
      }
    }
    $pagination .= '</div>';

    echo $pagination;
  }

}
