<?php

namespace app\core;

interface IUser
{
    public function getId():int;
    public function can(array $rights):bool;
    public function isSU():bool;
    public function isAdmin():bool;
    public function isEmployee():bool;
    public function isOlya(): bool;
    public function avatar():string;
    public function fi():string;
    public function mail():string;
}