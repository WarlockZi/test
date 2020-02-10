<?php

namespace app\model;

use app\core\App;
use app\core\Base\Model;

class Category extends Model
{

	public $table = 'category';

	public function getCategoryParents($parentId, $parents = [], $i = -1)
	{

		if ($parentId) {
			$sql = 'SELECT * FROM category WHERE id = ?';
			$params = [$parentId];
			$parent = $this->findBySql($sql, $params);
			$parent[0]['props'] = explode(',', $parent[0]['props']);
			$parents = array_merge($parents, $parent);
			$i++;
			return $this->getCategoryParents($parents[$i]['parent'], $parents, $i);
		} else {
			return array_reverse($parents);
		}
	}

	public function getAssocCategory($options)
	{
		$onlyActive = (isset($options['active']) && $options['active'])?" WHERE `act` = 1" : "";
		$sql = 'SELECT * FROM category' . $onlyActive;
		$res = App::$app->category->findBySql($sql, $params = array());

		if ($res !== FALSE) {
			$all = [];
			foreach ($res as $key => $v) {
				$params = [$v['id']];
				$sql = 'SELECT * FROM products WHERE parent = ?';
				$res = App::$app->product->findBySql($sql, $params);
				$all[$v['id']] = $v;
				$all[$v['id']]['products'] = $res;
			}
			return $all;
		}
		return false;
	}

	public function categoriesTree($cat)
	{

		$tree = [];
		$data = $cat;
		foreach ($data as $id => &$node) {
			if (isset($node['parent']) && !$node['parent']) {
				$tree[$id] = &$node;
			} elseif (isset($node['parent']) && $node['parent']) {
				$data[$node['parent']]['childs'][$id] = &$node;
			}
		}
		return $tree;
	}

	function findValueByKey($inputArray, $findKey)
	{
		foreach ($inputArray as $key => $value) {
			if ($findKey == $key) {
				return $value;
			} elseif (is_array($value) && isset($value['childs'])) {
				$tmp = $this->findValueByKey($value['childs'], $findKey);
				if ($tmp !== false) {
					return $tmp;
				}
			}
		}
		return false;
	}

	public function getCategoriesProducts($aCategories, $products = [])
	{
		foreach ($aCategories as $key => $value) {
			if (isset($value['childs']) && is_array($value['childs'])) {
				$this->getCategoriesProducts($value['childs'], $products);
				$products = array_merge($products, $value['products']);
			}
			$products = array_merge($products, $value['products']);
		}
		return $products;
	}

	public function getCategoryChildren($parentId)
	{
		$cat = $this->getAssocCategory(['act' => 0]);
		$tree = $this->categoriesTree($cat);
		$categories = $this->findValueByKey($tree, $parentId);
		if (isset($categories['childs'])) {
			$children['categories'] = $categories['childs'];
			$products = $this->getCategoriesProducts($categories['childs']);
		} else {
			$products = $this->getCategoriesProducts(array($categories));
		}
		if ($products) {
			$children['products'] = $products;
		}
		if (!$products && !isset($categories['childs'])) {
			return FALSE;
		}
		return $children;
	}

//   public function getCategoryPropertiesSnippet($Id) {
//
//      $sql = 'SELECT * FROM props WHERE parent = ?';
//      $params = [$Id];
//      $arr['property'] = $this->findBySql($sql, $params);
//
//      ob_start();
//      include APP . '/view/Adm_catalog/snippet/KeyVal.php';
//      $cont = ob_get_clean();
//      return $cont;
//   }

	public function isCategory($url)
	{
		$category = 0;
		if (!$category) {
			$arr = explode('/', $url);
			if (count($arr) > 3) {
				http_response_code(404);
				exit(include '../../public/404.html');
			}
			$category = $this->findOne($arr[0], 'alias');
			if ($category && is_array($category)) {
				$category['parents'] = $this->getCategoryParents($category['parent']);
				$category['children'] = $this->getCategoryChildren($category['id']);
			}
		}
		if (!$category) {
			return FALSE;
		};
		return $category;
	}

	public function getCategory($id)
	{

		$category = $this->findOne($id);

		if ($category && is_array($category)) {
			$category['props'] = explode(',', $category['props']);
			$category['parents'] = $this->getCategoryParents($category['parent']);
			if ($ch = $this->getCategoryChildren($category['id']))
				$category['children'] = $ch;
			$parentProps = [];
			foreach ($category['parents'] as $value) {
//            $arr = array_intersect($parentProps, $value['prop']);
				$parentProps = array_merge($parentProps, $value['props']);
			}
			$category['parentProps'] = array_unique($parentProps);
		}
		if (!$category) {
			return FALSE;
		};
		return $category;
	}

	public function getInitCategories($fromCache = 0)
	{
		if ($fromCache) {
			$list = App::$app->cache->get('list');
			if (!$list) {
				$list = $this->getInitCategories();
				App::$app->cache->set('list', $list, 30);
			}
		}

		$sql = 'SELECT * FROM category WHERE parent = 0 AND act = 1';
		$arr = $this->findBySql($sql);
		return $arr;
	}

}
