<?php

namespace app\model;

use app\core\App;


class Product extends Model
{

	public $table = 'products';
	public $model = 'product';

	protected function createImgPaths($alias, $fname,  $ext, $isOnly, $rate = 800)
	{
		$ext = $ext ?: 'jpg';
		$p['filename'] = $rate ? "{$fname}-{$rate}.{$ext}" : "{$fname}.{$ext}";
		$p['group'] = $_SERVER['DOCUMENT_ROOT'] . "/pic/{$alias}/";
		$p['to'] = $p['group'] . $p['filename'];
		$p['rel'] = "{$alias}/{$fname}";
		return $p;
	}


	public function getImgParams()
	{
		return ['toExt' => 'webp',
			'quality' => 75,
			'sizes' => [0, 80, 300, 700]
		];
	}

	public function uploadIMG($alias, $sub, $isOnly, $file)
	{
		$arr = extract($this->getImgParams());
		$fname = substr($file['name'], 0, strlen($file['name']) - 4);
		foreach ($sizes as $size) {
			if (!$size) {
				$ps = $this->createImgPaths($alias, $fname, null, null, $isOnly);
				move_uploaded_file($file['tmp_name'], $ps['to']);
			} else {
				$pX = $this->createImgPaths($alias, $fname, $size, $toExt, $isOnly);
				$new_image = new picture($ps['to']);
				$new_image->autoimageresize($size, $size);
				$new_image->imagesave($toExt, $pX['to'], $quality, 0777);
			}
		}
		return $pX['rel'];
	}

	public function getProductImg($id)
	{
		$params = [$id];
		$sql =
			"SELECT * FROM `product_pic` as pp " .
			"LEFT JOIN " .
			"`pic` as p " .
			"ON p.id = pp.pic_id " .
			"where pp.product_id = ?";
		$arr = $this->findBySql($sql, $params);

		return $arr;
	}

	public function updateProductIMG($arr)
	{

		if (!$_FILES || !$_FILES['file']) {
			exit('Файл не передан на сервер!');
		}
		extract($arr);
		$hash = hash_file('md5', $file['tmp_name']);

		if ($isOnly) {// у данной продукции есть картинка, но не такая
			$thisProductHasSomePic = $this->thisProductHasSomePic($model, $picType, $pkeyVal);
			if (isset($thisProductHasSomePic)) {// у продукта уже есть картинка
				if ($newPath = $this->uploadIMG($alias, $picType, $isOnly, $_FILES['file'])) {
					if ($hash !== $thisProductHasSomePic['hash']) { // и отличается от вставляемой
						exit($this->updatePic($hash, $thisProductHasSomePic['path'], $thisProductHasSomePic['id']));
					}
				}
			} else {
				if ($newPath = $this->uploadIMG($alias, $picType, $isOnly, $_FILES['file'])) {
					$this->isertImgDB($newPath, $arr, $hash);
				}
			}
		} else { // множественная картинка
			$thisProductHasThisPic = $this->thisProductHasThisPic($hash, $model, $picType, $pkeyVal);
			if (!$thisProductHasThisPic) { /// у данного товара еще нет такой картинки картинки
				if ($newPath = $this->uploadIMG($alias, $picType, $isOnly, $_FILES['file'])) {
					$this->isertImgDB($newPath, $arr, $hash);
				}
			} else {
				exit('Такая картинка уже есть!');
			}// иначе у данного товара уже есть такая картинка-не делаем ничего
			if ($newPath = $this->uploadIMG($alias, $picType, $isOnly, $_FILES['file'])) {
				$this->isertImgDB($newPath, $arr, $hash);
			}
		}
		exit('All is done');
	}

	public function updatePic($hash, $path, $id)
	{
		$sql = "UPDATE `pic` SET `hash` = ?, `path` = ? WHERE `id` = ?";
		$params = [$hash, $path, $id];
		return $this->insertBySql($sql, $params);
	}

	public function thisProductHasSomePic($model, $picType, $pkeyVal)
	{
		$sql = "SELECT * FROM `pic` WHERE `model` = ? AND `sub` = ? AND `modelId` = ?";
		$params = [$model, $picType, $pkeyVal];
		return $thisProductHasSomePic = $this->findBySql($sql, $params)[0];
	}

	public function thisProductHasThisPic($hash, $model, $picType, $pkeyVal)
	{
		$sql = "SELECT * FROM `pic` WHERE `hash` = ? AND `model` = ? AND `sub` = ? AND `modelId` = ?";
		$params = [$hash, $model, $picType, $pkeyVal];
		return $thisProductHasThisPic = $this->findBySql($sql, $params);
	}

	public function isertImgDB($newPath, $arr, $hash)
	{
		extract($arr);
		$sql = "INSERT INTO `pic` (`alias`, `path`, `hash`, `model`, `sub`, `modelId`)VALUES (?, ?, ?, ?, ?, ?)";
		$params = [$alias, $newPath, $hash, $model, $picType, $pkeyVal];
		$this->insertBySql($sql, $params);
		exit($newPath);
	}

	public function delProductImg($arr)
	{
		extract(getImgParams());
		extract($arr);
		$sql = "SELECT * FROM pic WHERE `model` = ? AND `modelId` = ? AND `path`= ? AND `sub`= ?";
		$params = [$model, $pkeyVal, $delPath, $sub];
		$res = $this->findBySql($sql, $params);
		if (count($res) == 1) {// eсли
			$dir = ROOT . '/pic/' . $delPath;
			if (is_dir($dir)) {
				$res1 = Model::removeDirectory($dir);
			}
		}
		$sql1 = "DELETE FROM pic WHERE `model` = ? AND `modelId` = ? AND `path`=? AND `sub`= ?";
		$params1 = [$model, $pkeyVal, $delPath, $sub];
		$this->insertBySql($sql1, $params1);
		exit($delPath);
	}

	public function getProductParents($parentId)
	{

		if ($parentId) {
			$sql = 'SELECT * FROM category WHERE id = ?';
			$params = [$parentId];
			$parent = $this->findBySql($sql, $params)[0];
			return $parent;
		}
	}

	public static function getSale()
	{
		$model = new static;
		$sql = 'SELECT * FROM products WHERE sale = ?';
		$params = [1];
		$products = $model->findBySql($sql, $params);
		return $products;
	}

	public function isProduct($url)
	{

		if ($product = $this->findOneWhere($url, 'alias')) {
			$product['parents'][] = $this->getProductParents($product['parent']);
			while ($last = end($product['parents'])['parent']) {
				$product['parents'][] = $this->getProductParents($last);
			}
			App::$app->cache->set('product' . $url, $product, 30);
			return $product;
		};
		return FALSE;
	}

	public function productsCnt()
	{

		$sql = 'SELECT COUNT(*) FROM PRODUCTS';
		$arr = $this->findBySql($sql)[0];
		return $arr['COUNT(*)'];
	}

	public function getProducts($categoryId)
	{

		$param = [$categoryId];
		$sql = 'SELECT * FROM products WHERE parent = ?';
		$products = $this->findBySql($sql, $param);
		return $products;
	}

	public function getProduct($productId)
	{

		$param = [$productId];
		$sql = 'SELECT * FROM products WHERE id = ? LIMIT 1';
		$product = $this->findBySql($sql, $param);
		return $product[0];
	}

}




