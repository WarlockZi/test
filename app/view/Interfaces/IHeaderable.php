<?php


namespace app\view\Interfaces;


interface IHeaderable
{
	function setHeader(array $user);
	function getHeader();
}