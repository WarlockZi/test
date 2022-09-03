<?php


namespace app\Repository;


use app\controller\Controller;
use app\controller\FS;

class ProductRepository extends Controller
{

	public static function clear()
	{
		$deleted = FS::delFilesFromPath("\pic\product\\");
		ImageRepository::delAll();
	}
}