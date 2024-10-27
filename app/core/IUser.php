<?php

namespace app\core;

interface IUser
{
    public function getId():int;
    public function can(array $rights):bool;

}