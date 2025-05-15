<?php

namespace app\action\admin;


use app\service\Storage\StorageProd;

class WishAction
{
    public function __construct()
    {
    }

    public function wishes(): string
    {
        return StorageProd::getFileContent('wish');
    }

}