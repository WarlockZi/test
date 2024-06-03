<?php


namespace app\Services\Logger;


use app\core\FS;

class ErrorLogger implements ILogger
{
	protected string $logFile;

	public function __construct($fileName = 'errors.txt')
	{
        $this->setFile($fileName);
	}

	public function read():string
	{
		return file_get_contents($this->logFile);
	}

	public function write(string $content):bool
	{
//        file_put_contents(time(), $content.PHP_EOL.PHP_EOL, FILE_APPEND);
		return file_put_contents($this->logFile,  PHP_EOL.PHP_EOL.date('Y-m-d H:i:s').PHP_EOL.$content.PHP_EOL, FILE_APPEND);
	}

	public function setFile(string $fileName): ILogger
	{
        $this->logFile = FS::platformSlashes(ROOT.'/app/Storage/log/'.$fileName);
		return $this;
	}

	public function clear(): void
	{
		if ($this->logFile) file_put_contents($this->logFile,'');
	}
}