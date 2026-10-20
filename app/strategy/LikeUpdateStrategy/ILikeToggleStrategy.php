<?php

namespace app\strategy\LikeUpdateStrategy;

interface ILikeToggleStrategy
{
public function toggleLike(array $req):bool;
}