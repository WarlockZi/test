<?php


namespace app\Services\Logger;


interface ILogger
{
	public function read():string ;
	public function write(string $content);
	public function setFile(string $fileName):ILogger;
	public function clear():void ;

}