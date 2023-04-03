<?php

namespace app\Services\XMLParser;

use app\model\Category;
use app\Services\Slug;

class Parser
{
  protected $file;
  protected $xml;
  protected $xmlObj;

  public function __construct(string $file)
  {
    if (!is_readable($file))exit();
    $this->file= $file;
    $this->xml = simplexml_load_file($this->file);
    $this->xmlObj = json_decode(json_encode($this->xml), true);
  }


  protected function isAssoc(array $arr)
  {
    if (array() === $arr) return false;
    return array_keys($arr) !== range(0, count($arr) - 1);
  }

//	public function loadPrices(){
//		new LoadPrices($this->file);
//	}
//
//	public function loadCategories(){
//		new LoadCategories($this->file);
//	}
//
//	public function loadProducts(){
//		new LoadProducts($this->file);
//	}
}