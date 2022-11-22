<?php


namespace app\controller;


class Address
{

	public static $factAddress = 'г. Вологда, ул. Залиненйная 26, скл.4';
	public static $postCode = '160010';

	/**
	 * @return string
	 */
	public static function getFactAddress(): string
	{
		return self::$factAddress;
	}

	/**
	 * @param string $factAddress
	 */
	public static function setFactAddress(string $factAddress): void
	{
		self::$factAddress = $factAddress;
	}

	public static function postCodeDecorator(string $address)
	{
		return self::$postCode.', '.$address;
	}

}