<?php

namespace app\Services\XMLParser;

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

}