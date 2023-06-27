<?php


namespace app\Services\Logger;


use app\Storage\StorageLog;

class FileLogger implements ILogger
{
	protected $logFile;

	public function __construct()
	{
		$this->logFile = StorageLog::getFile('log');
	}


	public function read($filename)
	{
		// TODO: Implement read() method.
	}


	public function write($content)
	{
		return file_put_contents($this->logFile, $content);
	}
}