<?php


namespace app\Repository;


use app\model\User;

class UserRepository
{

	public static function userManager()
	{
		return User::query()
			->where('rights', 'LIKE', '%role_manager%')
			->get();
	}

	public static function returnPassword(array $data): array
	{
		return User::query()
			->where('email', $data['email'])
			->select('id', 'password', 'email')
			->get()[0]
			->toArray();
	}

}