<?php

namespace app\model;

use app\core\DB;
use Engine\DI\DI;


abstract class Model
{
	protected $pdo;
	public $table;
	public $model;

	protected $user;
	public $items;

	public function __construct()
	{
		$this->pdo = DB::instance();
	}

	protected function auth($ext): void
	{
		$user = User::findOneWhere('id', $_SESSION['id'] ?? null);
		if (!$user) {
			throw new \Exception('Нет пользователя ');
		}
		$this->user = $user;
		$rightName = $this->model . '_' . $ext;
		if (!User::can($this->user, $rightName)) {
			exit(json_encode(['error' => 'Нет права ' . $rightName]));
		}
	}

	public static function create($values = [], $register = false)
	{
		$model = new static();
		if (!$register) $model->auth('create');

		if (isset($values['id'])) unset($values['id']);
		if (isset($values['token'])) unset($values['token']);

		$fillable = $model->fillable;
		foreach ($values as $k => $v) {
			if (array_key_exists($k, $model->fillable)) {
				$fillable[$k] = $v;
			}
		}

		$fields = implode(',', array_keys($fillable));
		$param = array_values($fillable);
		$questionMarks = array_fill(0, count($fillable), '?');
		$strQMarks = implode(',', array_values($questionMarks));

		$sql = "INSERT INTO {$model->table} ({$fields}) VALUES ({$strQMarks})";
		try {
			$model->insertBySql($sql, $param);
			return $model->autoincrement();
		} catch (Exception $e) {
			exit('Не создан' . $e->getMessage());
		}
	}

	public static function update($values = [])
	{
		$model = new static();
		$model->auth('update');

		$id = $values['id'];
		if (!$id) exit('empty or undefined id');
		unset($values['id']);
		unset($values['token']);
		$par = '';
		foreach ($values as $key => $value) {
			if ($value) {
				if (is_array($value)) {
					$value = implode(',', $value);
				}
				$par .= $key . " = '" . $value . "', ";
			} else {
				$par .= $key . " = NULL, ";
			}
		}
		$par = trim($par, ' '); // first trim last space
		$par = trim($par, ',');

		$sql = "UPDATE `{$model->table}` SET {$par} WHERE id = ?";

		if ($model->insertBySql($sql, [$id])) {
			return true;
		}
		return 'Видимо, ошибка в запросе!';
	}


	public static function delete($id)
	{
		$model = new static();
		$model->auth('delete');

		$param = [$id];
		$sql = "DELETE FROM {$model->table} WHERE  id = ?";
		return $model->insertBySql($sql, $param);
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

	public function morphTo($table, $type, $id): array
	{
		$morphTable = $this->makeMorphTableName($this->model, $table);
		$field = $this->makeFieldName($this->model);
		$param = [$id];

		$sql = "SELECT * FROM $morphTable WHERE $field=? AND type='$type'";
		$res = $this->findBySql($sql, $param);
		$arr = [];
		foreach ($res as $item) {
			$m = $this->findOneWhere('id', $item['type_id']);

			$arr[] = $m;
		}
		return $arr;
	}


	public function firstOrCreate($field, $val, $row)
	{
		$model = new static();
		$model->auth('create');

		$found = $model::findOneWhere($field, $val);
		if (!$found) {
			$model::create($row);
			return true;
		}
		return $found;
	}


	public static function updateOrCreate(array $values)
	{
		$model = new static();
		$id = $values['id'] ?? '';
		if ($id) {
			$model::update($values);
			return true;
		} else {
			$id = $model::create($values) - 1;
			return $id;
		}
	}

	public static function load($id)
	{
		$model = new static();
		$fields = $model::findOneWhere('id',$id);
		if ($fields) {
			$fields = $fields[0];

			$model->fillable['id'] = $id;
			foreach ($model->fillable as $k => $v) {
				if (array_key_exists($k, $fields)) {
					$model->fillable[$k] = $fields[$k];
				}
			}
			return $model;
		}
		return false;
	}

	private function fillModel(array $fields): void
	{
		foreach ($fields as $k => $v) {
			$this->fields[$k] = $v;
		}
	}

	public static function findOneModel($id = ''): Model
	{
		$model = new static();
		$sql = "SELECT * FROM {$model->table} WHERE id IN (?)";
		$fields = $model->pdo->query($sql, [$id])[0] ?? [];
		$model->fillModel($fields);
		return $model;
	}

	public static function find($id = [])
	{
		$model = new static();
		if (is_array($id)) {
			$id = implode(',', array_map('intval', $id));
		}
		$sql = "SELECT * FROM {$model->table} WHERE id IN (?)";
		return $model->pdo->query($sql, [$id]);
	}


	public static function findAll($table = '', $sort = '')
	{
		$model = new static();
		$sql = "SELECT * FROM " . ($table ?: $model->table) . ($sort ? " ORDER BY {$sort}" : "");
		return $model->pdo->query($sql);
	}

	private function prepareQuerry($array)
	{
		$filds = array_keys($array);
		$params = array_values($array);

		$str = "{$filds[0]}='{$params[0]}'";
		array_shift($array);
		foreach ($array as $k => $v) {
			$s = $k . "='" . $v . "'";
			$str .= " AND " . $s;
		}
		return $str;
	}

	public static function findAllWhere($fieldOrArray, $value = '')
	{
		$model = new static();

		if (is_array($fieldOrArray)) {
			$querry = $model->prepareQuerry($fieldOrArray);
			$sql = "SELECT * FROM {$model->table} WHERE {$querry}";
			return $model->pdo->query($sql, []);
		}
		$sql = "SELECT * FROM {$model->table} WHERE $fieldOrArray = ? ";
		return $model->pdo->query($sql, [$value]);
	}

	public static function findOneWhere($field, $value)
	{
		$model = new static();
		$sql = "SELECT * FROM {$model->table} WHERE $field = ? LIMIT 1";
		$item = $model->pdo->query($sql, [$value]);
		return $item[0] ?? null;
	}

	public function groupBy($field = '')
	{
		$this->groupBy = " GROUP BY {$field}" ?? '';
		return $this;
	}

	public function orderBy($field)
	{
		if (is_array($field)) {
			$str = implode(', ', $field);
			$this->orderBy = " ORDER BY {$str}" ?? '';
			return $this;
		} elseif (is_string($field)) {
			$this->orderBy = " ORDER BY {$field}" ?? '';
			return $this;
		}
	}

	public function pluck($fields = [])
	{
		$this->pluck = $fields ?? '*';
		return $this;
	}

	public function limit(int $limit)
	{
		$this->limit = " LIMIT {$limit}" ?? '';
		return $this;
	}

	public static function where($field, $operator, $value)
	{
		$model = new static();
		$model->where = " WHERE {$field} {$operator} {$value}" ?? '';
		return $model;
	}


	public final function get()
	{
		if (property_exists($this, 'hasMany')
			&& ($this->hasMany)) {
			$this->getWith();
			return $this;
		}
		$pluck = $this->pluck ?? '*';
		$where = $this->where ?? '';
		$orderBy = $this->orderBy ?? '';
		$groupBy = $this->groupBy ?? '';
		$limit = $this->limit ?? '';
		$sql = "SELECT {$pluck} FROM {$this->table} {$where}{$groupBy} {$orderBy} {$limit}";
		$this->fields = $this->pdo->query($sql, []);
		$this->items = $this->fields;
		return $this->fields;
	}

	public function with($child): self
	{
		$name = 'app\model\\' . ucfirst($child);
		$model = new $name;
		if ($child) {
			$this->hasMany[$name]['model'] = $model->model;
			$this->hasMany[$name]['table'] = $model->table;
			$this->with = "SELECT * FROM {$model->table} WHERE {$this->model}_id IN ";
		}
		return $this;
	}

	public function hasMany(string $class)
	{
		if ($this->hasMany[$class]) {
			return $this->hasMany[$class]['items'];
		}
	}

	public function hasOne(string $class)
	{
		$instance = new $class;
		$field = $instance->model . '_id';
		return $instance::where($field, '=', $this->fillable[$field])
			->limit(1)
			->get();
	}

	public final function getWith()
	{
		foreach ($this->hasMany as &$hasManyItem) {
			$childTable = ucfirst($hasManyItem['model']);

			$pluck = $this->pluck ?? '*';
			$where = $this->where ?? '';
			$orderBy = $this->orderBy ?? '';
			$sql = "SELECT {$pluck} FROM {$this->table} {$where} {$orderBy}";
			$this->items = $this->pdo->query($sql, []);

			if ($this->items) {

				$ids = [];
				foreach ($this->items as $i => $item) {
					array_push($ids, $item['id']);
				}
				$ids = implode(',', $ids);
				$sql = $this->with . '(' . $ids . ')';
				$hasManyItem['items'] = $this->pdo->query($sql, []);
				foreach ($this->items as &$item) {
					foreach ($hasManyItem['items'] as $child) {
						$identifier = $this->model . '_id';
						if ($item['id'] === $child[$identifier]) {
							$item[$childTable][] = $child;
						}
					}
				}
			}
		}
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


	public function autoincrement()
	{
		$params = [$this->table];
		$sql = "SHOW TABLE STATUS FROM {$_ENV["DB_DB"]} LIKE ?";
		return (int)$this->pdo->query($sql, $params)[0]['Auto_increment'];
	}

	public function findBySql($sql, $params = [])
	{
		return $this->pdo->query($sql, $params);
	}

	public function insertBySql($sql, $params = [])
	{
		return $this->pdo->execute($sql, $params);
	}

	function multi_implode($glue, $array)
	{
		$_array = array();
		foreach ($array as $val)
			$_array[] = is_array($val) ? $this->multi_implode($glue, $val) : $val;
		return implode($glue, $_array);
	}


}
