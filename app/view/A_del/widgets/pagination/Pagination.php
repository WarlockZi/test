<?php

namespace app\view\widgets\pagination;

use app\model\Model;
use app\core\DB;
use app\model\Test;

class Pagination extends Model
{

	protected $id;
	protected $testData;
	protected $tpl;
	protected $class = 'pagination';
	protected $cache = 3600;
	protected $sql = "SELECT * FROM tests";

	public function __construct($options = [])
	{
		$this->getOptions($options);
		$this->run();
	}

	public function getOptions($options)
	{
		foreach ($options as $k => $v) {
			if (property_exists($this, $k)) {
				$this->$k = $v;
			}
		}
	}

	protected function run()
	{
		$count_questions = count($this->testData);
		$pagination = '<div class="pagination">';
		for ($i = 1; $i <= $count_questions; $i++) {
			$pagination .= "<div data-pagination=" . $this->testData[$i - 1]['id'] . " class = 'p-no-active' ><div>" . $i . "</div></div>";
		}
		$pagination .= '</div>';

		echo $pagination;
	}

}
