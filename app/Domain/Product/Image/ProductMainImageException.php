<?php


namespace app\Domain\Product\Image;


use Throwable;

class ProductMainImageException extends \Exception
{
	public function __construct($message = "", $code = 0, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}

}