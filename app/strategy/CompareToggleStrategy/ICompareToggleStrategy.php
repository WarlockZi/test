<?php

namespace app\strategy\CompareToggleStrategy;

interface ICompareToggleStrategy
{
public function toggleCompare(array $req):bool;
}