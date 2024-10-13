<?php


namespace app\controller;


use app\Repository\SettingsRepository;

class Address
{
	public static $factAddress = '<span itemprop="addressLocality">г. Вологда</span>, <span itemprop="streetAddress">ул. Залинейная 26, скл.4</span>';
	public static $postCode = '<span itemprop="postalCode">160010</span>';

	public static function getFactAddress(): string
	{
		$settings = (new SettingsRepository())->initial();
		if (isset($settings['shipAddress']['value'])){
			$shipAddres = $settings['shipAddress']['value'];
		}
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