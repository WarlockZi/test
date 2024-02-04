<?php


namespace app\Services\Logger;


interface ILogger
{
	public function read(string $filename);
	public function write(string $content);
	public function setFile(string $fileName):ILogger;

}