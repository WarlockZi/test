<?php


namespace app\controller;


use app\Repository\SettingsRepository;

class Address
{
	public static $factAddress = 'г. Вологда, ул. Залинейная 26, скл.4';
	public static $postCode = '160010';

	public static function getFactAddress(): string
	{
		$shipAddres = (new SettingsRepository())->initial()['shipAddress']['value'];
		return $shipAddres??self::$factAddress;
	}


	public static function setFactAddress(string $factAddress): void
	{
		self::$factAddress = $factAddress;
	}

	public static function postCodeDecorator(string $address)
	{
		return self::$postCode.', '.$address;
	}

}