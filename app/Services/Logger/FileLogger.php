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

	public function read():string
	{
		return file_get_contents($this->logFile);
	}


	public function write(string $content):bool
	{
		return file_put_contents($this->logFile, $content, FILE_APPEND);
	}

	public function setFile(string $fileName): ILogger
	{
		$this->logFile = StorageLog::getFile($fileName);
		return $this;
	}

	public function clear(): void
	{
		if ($this->logFile) file_put_contents($this->logFile,'');
	}
}