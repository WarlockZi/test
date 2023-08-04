<?php


namespace app\Repository;


use app\model\User;

class UserRepository
{

	public static function returnPassword(array $data):array
	{
		return User::where('email', $data['email'])
			->select('id', 'password', 'email')
			->get()[0]
			->toArray();
	}

}