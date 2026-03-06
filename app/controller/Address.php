<?php


namespace app\controller;


class Address
{
    public static $factAddress = '<span class="city" itemprop="addressLocality">г. Вологда,</span>
<span class="address" itemprop="streetAddress">ул. Залинейная 26, скл.4</span>';
    public static $postCode = '<span itemprop="postalCode">160010</span>';

    public static function getFactAddress(): string
    {
        return $shipAddres ?? self::$factAddress;
    }


    public static function setFactAddress(string $factAddress): void
    {
        self::$factAddress = $factAddress;
    }

    public static function postCodeDecorator(string $address)
    {
        return self::$postCode . ', ' . $address;
    }

}