<?php


namespace app\controller\Interfaces;


interface IModelable
{
	function setModel(string $model);
	function getModel();
}