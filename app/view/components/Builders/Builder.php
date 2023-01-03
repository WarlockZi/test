<?php


namespace app\view\components\Builders;


class Builder
{
	protected function clean(string $res):string
	{
		$regex[0] = "/\r\r+?/";
		$regex[1] = "/\n\n+?/";
		$res = preg_replace($regex,"",$res);

		$regex = "/\t\t+?/";
		$res = preg_replace($regex,"\t",$res);
		return $res;
	}

}