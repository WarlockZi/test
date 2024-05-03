<?php


namespace app\Services\Logger;


use app\Storage\StorageLog;

class ErrorLogger implements ILogger
{
	protected string $logFile;
    protected string $logPath;

	public function __construct($fileName = 'errors.txt')
	{
        $this->logPath = ROOT.'/app/Storage/log/';
		$this->logFile = StorageLog::getFile($fileName);
	}

	public function read():string
	{
		return file_get_contents($this->logFile);
	}


	public function write(string $content):bool
	{
        file_put_contents(time(), $content.PHP_EOL, FILE_APPEND);
		return file_put_contents($this->logFile, $content.PHP_EOL.PHP_EOL, FILE_APPEND);
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