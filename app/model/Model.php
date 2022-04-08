<?php

namespace app\model;

use app\core\App;
use app\core\DB;
use mysql_xdevapi\Exception;

abstract class Model
{
	protected $pdo;
	protected $sql;
	protected $table;
	protected $model;
	protected $pk = 'id'; // Конвенция Первичный ключ по умолчанию будет 'id', но можно его переопределить

	public function __construct()
	{
		$this->pdo = DB::instance();
	}

	public static function create($values = [])
	{
		$model = new static();

		if (isset($values['id'])) unset($values['id']);
		if (isset($values['token'])) unset($values['token']);
		$values = $values ? $values : $model->fillable;
		if (isset($values['id'])) unset($values['id']);
		$fields = implode(',', array_keys($values));
		$param = array_values($values);
		$questionMarks = array_fill(0, count($values), '?');
		$strQMarks = implode(',', array_values($questionMarks));

		$sql = "INSERT INTO {$model->table} ({$fields}) VALUES ({$strQMarks})";
		try {
			$model->insertBySql($sql, $param);
			return $model->autoincrement();
		} catch (Exception $e) {
			exit('Пользователь не создан' . $e->getMessage());
		}
	}

	public static function update($values = [])
	{
		$id = $values['id'];
		if (!$id) exit('empty or undefined id');
		unset($values['id']);
		unset($values['token']);
		$par = '';
		foreach ($values as $key => $value) {
			if ($value) {
				$par .= $key . " = '" . $value . "', ";
			} else {
				$par .= $key . " = NULL, ";
			}
		}
		$par = trim($par, ' '); // first trim last space
		$par = trim($par, ',');

		$model = new static();
		$sql = "UPDATE `{$model->table}` SET {$par} WHERE id = ?";

		if ($model->insertBySql($sql, [$id])) {
			return true;
		}
		return 'Видимо, ошибка в запросе!';
	}

	public static function delete($id)
	{
		$model = new static();
		$param = [$id];
		$sql = "DELETE FROM {$model->table} WHERE  id = ?";
		return $model->insertBySql($sql, $param);
	}

	public function hasMany($model, $var = [])
	{

		$this->findAllWhere('id', $var);

	}


	public function morphOne($type, $typeId, $id)
	{
		$morphTable = $this->model . '_morph';
		$firstId = $this->model . '_id';
		$secodId = 'type_id';
		$param = [$typeId];

		$sql1 = "SELECT * FROM $morphTable WHERE type='{$type}' AND $secodId=?";
		$found = $this->findBySql($sql1, $param);
		if (!$found) {
			$param = [$id, $typeId];
			$sql = "INSERT INTO {$morphTable} SET {$firstId}=?, type='{$type}', {$secodId}=?";
			return $this->insertBySql($sql, $param);
		} elseif ($found && $id !== $found[0]['id']) {
			$param = [$id, $typeId];
			$sql = "update $morphTable set $firstId = ? where type='$type' and $secodId= ?";
			$this->insertBySql($sql, $param);
		}
	}

	private function makeMorphTableName(string $name1, string $name2): string
	{
		$arr = [$name1, $name2];
		sort($arr);
		return $arr[0] . '_' . $arr[1];
	}

	private function makeFieldName(string $name): string
	{
		return $name . '_id';
	}

	public function morphTo($table, $type, $id)
	{

		$morphTable = $this->makeMorphTableName($this->model, $table);
		$field = $this->makeFieldName($this->model);
		$param = [$id];

		$sql = "SELECT * FROM $morphTable WHERE $field=? AND type='$type'";
		$res = $this->findBySql($sql, $param);
		$arr = [];
		foreach ($res as $item) {
			$m = $this->findOneWhere('id',$item['type_id']);

			$arr[]=$m ;
		}
		return $arr;

//		if (!) {
//			$sql = <<<here
//INSERT INTO $morphTable SET $firstId = ?, type="$type", $secodId= ?
//here;
//			$this->insertBySql($sql, $param);
//		}
	}


	public function firstOrCreate($field, $val, $row)
	{
		$found = App::$app->{$this->model}->findOneWhere($field, $val);
		if (!$found) {
			App::$app->{$this->model}->create($row);
			return true;
		}
		return $found;
	}


	protected function find($id = [])
	{
		$id = implode(',', array_map('intval', $id));
		$sql = "SELECT * FROM {$this->table} WHERE id IN (?)";
		return $this->pdo->query($sql, [$id]);
	}

	public function updateOrCreate($id, $values)
	{
		if ($this->find([$id])) {
			$this->update($values);
			return true;
		} else {
			$autoincrement = $this->create($values) - 1;
			return $autoincrement;
		}
	}


	public static function findAll($table = '', $sort = '')
	{
		$model = new static();
		$sql = "SELECT * FROM " . ($table ?: $model->table) . ($sort ? " ORDER BY {$sort}" : "");
		return $model->pdo->query($sql);
	}

	private function prepareQuerry($array)
	{
		$fields = implode(',', array_keys($array));
		$filds = array_keys($array);
		$params = array_values($array);
//		$questionMarks = array_fill(0, count($array), '?');
//		$strQMarks = implode(',', array_values($questionMarks));

		$str = "{$filds[0]}='{$params[0]}'";
		array_shift($array);
//		$str = "";
		foreach ($array as $k=>$v) {
			$s = $k."='".$v."'";
			$str .= " AND ".$s;
		}
		return $str;
	}

	public static function findAllWhere($fieldOrArray, $value='')
	{
		$model = new static();

		if (is_array($fieldOrArray)) {
			$querry = $model->prepareQuerry($fieldOrArray);
//			$sql = "SELECT * FROM {$model->table} ({$fields}) VALUES ({$strQMarks})";
			$sql = "SELECT * FROM {$model->table} WHERE {$querry}";
			return $model->pdo->query($sql, []);

		}

		$sql = "SELECT * FROM {$model->table} WHERE $field = ? ";
		return $model->pdo->query($sql, [$value]);

	}

	public static function findOneWhere($field, $value)
	{
		$model = new static();
		$sql = "SELECT * FROM {$model->table} WHERE $field = ? LIMIT 1";
		$item = $model->pdo->query($sql, [$value]);
		return $item[0] ?? null;
	}

	public function findBySql($sql, $params = [])
	{
		return $this->pdo->query($sql, $params);
	}

	public function insertBySql($sql, $params = [])
	{
		return $this->pdo->execute($sql, $params);
	}

	static function removeDirectory($dir)
	{
		if ($objs = glob($dir . "/*")) {
			foreach ($objs as $obj) {
				is_dir($obj) ? rmdir($obj) : unlink($obj);
			}
		}
		return rmdir($dir);
	}

	public function getBreadcrumbs($category, $parents, $type)
	{
		if ($type == 'category') {
// в parents массив из адресной строки - надо получить aliases
			foreach ($parents as $key) {
				$params = [$key['name']];
				$sql = 'SELECT * FROM category WHERE name = ?';
//если это категория, а ее не нашли вернем 404  ошибку
				if ($arrParents[] = $this->findBySql($sql, $params)[0]) {

				} else {
					http_response_code(404);
					include '../public/404.html';
					exit();
				}
			}
		}
		$breadcrumbs = "<a href = '/'>Главная</a>";
		if ($type == 'category') {
			foreach ($parents as $parent) {
				$breadcrumbs .= "<a  data-id = {$parent['id']} href = '/{$parent['alias']}'>{$parent['name']}</a>";
			}
			return $breadcrumbs . "<span data-id = {$category['id']}>{$category['name']}</span>";
		} else {
			$parents = array_reverse($parents);
			foreach ($parents as $parent) {
				$breadcrumbs .= "<a  data-id = {$parent['id']} href = '/{$parent['alias']}'>{$parent['name']}</a>";
			}
			return $breadcrumbs . "<span data-id = {$category['id']}>{$category['name']}</span>";
		}
	}


	public function getAssoc()
	{
		$res = $this->findBySql($this->sql, []);
		if ($res !== FALSE) {
			$all = [];
			foreach ($res as $key => $v) {
				$all[$v['id']] = $v;
			}
			return $all;
		}
	}

	public function hierachy($parent = 'parent')
	{
		$tree = [];
		$data = $this->data;
		foreach ($data as $id => &$node) {
			if (array_key_exists($parent, $node) && !$node[$parent]) {
				$tree[$id] = &$node;
			} elseif (isset($node[$parent]) && $node[$parent]) {
				$data[$node[$parent]]['childs'][$id] = &$node;
			}
		}
		return $tree;
	}

	public function getAssoc2(array $models)
	{
		foreach ($models as $key => $v) {
			$all[$v['id']] = $v;
		}
		return $all;
	}

	public function tree($parent = 'parent')
	{
		$data = $this->getAssoc2($this->data);
		foreach ($data as $id => &$node) {
			if (isset($node[$parent]) && !$node[$parent]) {
				$tree[$id] = &$node;
			} elseif (isset($node[$parent]) && $node[$parent]) {
				$data[$node[$parent]]['childs'][$id] = &$node;
			}
		}
		return $tree;
	}

	function multi_implode($glue, $array)
	{
		$_array = array();
		foreach ($array as $val)
			$_array[] = is_array($val) ? $this->multi_implode($glue, $val) : $val;
		return implode($glue, $_array);
	}

	public
	function clean_data($str)
	{
		return strip_tags(trim($str));
	}

	public
	function autoincrement()
	{
		$params = [$this->table];
		$sql = "SHOW TABLE STATUS FROM {$_ENV["DB_DB"]} LIKE ?";
		return (int)$this->pdo->query($sql, $params)[0]['Auto_increment'];
	}

}
