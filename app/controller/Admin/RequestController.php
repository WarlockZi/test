<?php

namespace app\controller\Admin;

use app\controller\AppController;
use app\model\Answer;

class RequestController Extends AppController
{
	protected $model = Answer::class;

	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex()
	{
		if ($_ENV['MODE'] === 'production') {
			$content = file_get_contents('/var/www/vitexopt/data/logs/vitexopt.ru.access.log');
			$content = preg_replace("/\n/", "<br/>\n", $content);
			$content = $this->filter($content);
			$content = $this->decorate($content);
		} else {
			$content = 'список';
		}

		$this->set(compact('content'));
	}

	protected function decorate($content){
		return "<div class='sync'>{$content}</div>";
	}

	protected function filter($content){
		$arr = explode('<br>', $content);
		var_dump($arr);
		$res = '';
		foreach ($arr as $str){
			if (!strpos($str, 'bots')) $res.=$str;
		}
		return $res;
	}

}
