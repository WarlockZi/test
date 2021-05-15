<?php

namespace app\controller;

use app\core\App;
use app\core\Base\View;

class SearchController extends AppController
{
	public function actionIndex()
	{
		if (empty($_GET['term']) && empty($_GET['q']))
			exit();

		$q = empty($_GET['q']) ? mb_strtolower($_GET['term']) : mb_strtolower($_GET['q']);
		if (get_magic_quotes_gpc()) {
			$q = stripslashes($q);
		}
		$escaped_req = addslashes('%' . $q . '%');
		$sql = "SELECT alias, name, preview_pic FROM products WHERE name LIKE ? AND `act`= 'Y' LIMIT 10";
		$params = [$escaped_req];
		$arr = App::$app->product->findBySql($sql, $params);
		$arr = array_slice($arr,0,10);
		$json = json_encode($arr);
		header('Content-Type: application/json');
		exit($json);
	}
}
