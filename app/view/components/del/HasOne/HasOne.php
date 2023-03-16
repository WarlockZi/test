<?php


namespace app\view\components\HasOne;


class HasOne
{
	protected $html;
	protected $relation;

	public static function create(string $relation){
		$hasOne = new static();
		$hasOne->relation = "data-hasone='{$relation}'";

		return $hasOne;
	}

	public function html(string $html){
		$this->html = $html;

		ob_start();
		$html = include ROOT . '/app/view/components/HasOne/template.php';
		return ob_get_clean();
	}

}