<?php

namespace app\view\widgets\Accordion;

use app\model\Model;
use app\core\App;


class Accordion extends Model
{
	protected $data;
	protected $model;
	protected $tree;
	protected $table;
	protected $template;
	protected $menuHTML;

	public function __construct($options = [])
	{
		$this->getOptions($options);
		$this->run();
	}
	protected function tree()
	{
		$tree = [];
		$data = $this->data;
		foreach ($data as $id => &$node) {
			if (array_key_exists('parent', $node) && !$node['parent']) {
				$tree[$id] = $node;
			} elseif (isset($node['parent']) && $node['parent']) {
				$tree[$node['parent']]['childs'][$id] = &$node;
			}
		}
		return $tree;
	}
	private function getTree($table)
	{
		$res = App::$app->{$table}->findAll($table);

		if ($res !== FALSE) {
			$all = [];
			foreach ($res as $key => $v) {
				$all[$v['id']] = $v;
			}
			return $all;
		}
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
//		$this->data = $this->getTree($this->table);
		$this->data = App::$app->{$this->model}->findAll();
		$this->template = include __DIR__.'/template.php';
		$this->tree = $this->tree($this->data);
		$this->menuHTML = $this->getMenuHtml($this->tree);
		$this->output();
	}


	public function getMenuHtml($tree, $tab = ' ')
	{
		$str = '';
		foreach ($tree as $id => $cat) {
			$str .= $this->catToTemplate($cat, $tab, $id);
		}
		return $str;
	}

	public function catToTemplate($cat, $tab = '', $id = '')
	{
		ob_start();
		require $this->tpl;
		return ob_get_clean();
	}

	protected function output()
	{
		return $this->menuHTML;
//		echo $this->menuHTML;
	}


}

