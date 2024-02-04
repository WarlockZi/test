<?php


namespace app\Services\Logger;


use app\Storage\StorageLog;

class FileLogger implements ILogger
{
	protected $logFile;

	public function __construct($fileName = 'log.txt')
	{
		$this->logFile = StorageLog::getFile($fileName);
	}

	public function read($filename)
	{
		return file_get_contents($this->logFile);
	}


	public function write($content)
	{
		if (!is_readable($this->logFile)) return false;
		return file_put_contents($this->logFile, $content, FILE_APPEND);
	}

	public function setFile(string $fileName): ILogger
	{
		$this->logFile = StorageLog::getFile($fileName);
		return $this;
	}
}