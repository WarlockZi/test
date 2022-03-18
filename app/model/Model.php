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

	public
	function autoincrement()
	{
		$params = [$this->table];
		$sql = "SHOW TABLE STATUS FROM {$_ENV["DB_DB"]} LIKE ?";
		return (int)$this->pdo->query($sql, $params)[0]['Auto_increment'];
	}

	public function create($values = [])
	{
		if (isset($values['id'])) unset($values['id']);
		if (isset($values['token'])) unset($values['token']);
		$values = $values ? $values : $this->fillable;
		if (isset($values['id'])) unset($values['id']);
		$fields = implode(',', array_keys($values));
		$param = array_values($values);
		$questionMarks = array_fill(0, count($values), '?');
		$strQMarks = implode(',', array_values($questionMarks));

		$sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$strQMarks})";
		try {
			$this->insertBySql($sql, $param);
			return $this->autoincrement();
		} catch (Exception $e) {
			exit('Пользователь не создан' . $e->getMessage());
		}
	}


	public
	function update($values)
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

		$sql = "UPDATE `{$this->table}` SET {$par} WHERE id = ?";

		if ($this->insertBySql($sql, [$id])) {
			return true;
		}
		return 'Видимо, ошибка в запросе!';
	}

	public function delete($id)
	{
		$param = [$id];
		$sql = "DELETE FROM {$this->table} WHERE  id = ?";
		return $this->insertBySql($sql, $param);
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


	public function morphTo($type, $typeId, $id)
	{
		$morphTable = $this->model . '_morph';
		$firstId = $this->model . '_id';
		$secodId = 'type_id';
		$param = [$id, $typeId];

		$sql1 = <<<here
SELECT * FROM $morphTable WHERE $firstId=? AND type="$type" AND $secodId=?
here;

		if (!$this->findBySql($sql1, $param)) {
			$sql = <<<here
INSERT INTO $morphTable SET $firstId = ?, type="$type", $secodId= ? 
here;
			$this->insertBySql($sql, $param);
		}
	}

	public
	function updateOrCreate($id, $values)
	{
		if ($this->find([$id])) {
			$this->update($values);
			return true;
		} else {
			$autoincrement = $this->create($values) - 1;
			return $autoincrement;
		}
	}

	public
	function firstOrCreate($field, $val, $row)
	{
		$found = App::$app->{$this->model}->findOneWhere($field, $val);
		if (!$found) {
			App::$app->{$this->model}->create($row);
			return true;
		}
		return $found;
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
	function findAll($table = '', $sort = '')
	{
		$sql = "SELECT * FROM " . ($table ?: $this->table) . ($sort ? " ORDER BY {$sort}" : "");
		return $this->pdo->query($sql);
	}

	public
	function all($table = '', $sort = '')
	{
		$sql = "SELECT * FROM " . ($table ?: $this->table) . ($sort ? " ORDER BY {$sort}" : "");
		return $this->pdo->query($sql);
	}

	public
	function findOne($id, $field = '')
	{
		$field = $field ?: $this->pk;
		$sql = "SELECT * FROM {$this->table} WHERE $field = ? LIMIT 1";
		$result = $this->pdo->query($sql, [$id]);
		return $result ? $result[0] : FALSE;
	}

	public
	function find($id = [])
	{
		$id = implode(',', array_map('intval', $id));
		$sql = "SELECT * FROM {$this->table} WHERE id IN (?)";
		return $this->pdo->query($sql, [$id]);
	}






	public static function findOneWhere($field, $value)
	{
		return (new static())->findOneWhere1($field, $value);
	}

	private function findOneWhere1($field, $value)
	{
		$sql = "SELECT * FROM {$this->table} WHERE $field = ? LIMIT 1";
		$item = $this->pdo->query($sql, [$value]);
		return $item[0] ?? null;
	}





	public
	function findAllWhere($field, $value)
	{
		$sql = "SELECT * FROM {$this->table} WHERE $field = ? ";
		return $this->pdo->query($sql, [$value]);
	}

	public
	function findBySql($sql, $params = [])
	{
		return $this->pdo->query($sql, $params);
	}

	public
	function insertBySql($sql, $params = [])
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

	public
	function getBreadcrumbs($category, $parents, $type)
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

	public
	function getAssoc($table)
	{
		$params = array();
		$res = App::$app->{$table}->findBySql($this->sql, $params);

		if ($res !== FALSE) {
			$all = [];
			foreach ($res as $key => $v) {
				$all[$v['id']] = $v;
			}
			return $all;
		}
	}

	protected
	function hierachy()
	{
		$tree = [];
		$data = $this->data;
		foreach ($data as $id => &$node) {
			if (array_key_exists('parent', $node) && !$node['parent']) {
				$tree[$id] = &$node;
			} elseif (isset($node['parent']) && $node['parent']) {
				$data[$node['parent']]['childs'][$id] = &$node;
			}
		}
		return $tree;
	}

}
