<?php

namespace app\Services\XMLParser;

use app\Services\Logger\FileLogger;

class Parser
{
	protected $file;
	protected $xml;
	protected $xmlObj;
	protected $logger;

	public function __construct(string $file)
	{
		if (!is_readable($file)) exit();
		$this->logger = new FileLogger();
		$this->file = $file;
		$this->xml = simplexml_load_file($this->file);
		$this->xmlObj = json_decode(json_encode($this->xml), true);
	}

	protected function now()
	{
		return date("F j, Y, g:i a") . "\n";
	}


	protected function isAssoc(array $arr)
	{
		if (array() === $arr) return false;
		return array_keys($arr) !== range(0, count($arr) - 1);
	}

	protected function log($content)
	{
		$this->logger->write($content);
	}

}