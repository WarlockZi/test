<?php


namespace app\Services\Logger;


use app\Storage\StorageLog;

class FileLogger implements ILogger
{
	protected $logFile;

	public function __construct($filename = 'log.txt')
	{
		$this->logFile = StorageLog::getFile($filename);
	}


	public function read($filename)
	{
		// TODO: Implement read() method.
	}


	public function write($content)
	{
		if (is_readable($this->logFile)) {
			return file_put_contents($this->logFile, $content, FILE_APPEND);
		}
		return false;
	}
}