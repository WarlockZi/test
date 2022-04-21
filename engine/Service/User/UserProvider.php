<?php


namespace Engine\Service\User;


use app\model\User;
use Engine\Service\AbstractProvider;

class UserProvider extends AbstractProvider
{

	public $serviceName = 'user';

	public function init()
	{
//		if ($_SESSION['id']) {
//			$user = User::findAllWhere('id', $_SESSION['id']);
//			$this->di->set($this->serviceName, $user);
//		}
	}
}