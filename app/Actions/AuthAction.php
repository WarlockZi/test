<?php


namespace app\Actions;

use app\model\User;
use app\Services\ShortlinkService;

class AuthAction
{
	protected $salt = "popiyonovacheesa";

	public function createUser(array $req)
	{
		$user['email'] = $req['email'];
		$user['password'] = $this->preparePassword($req['password']);
		$user['hash'] = md5(microtime());
		$user['rights'] = 'user_update';
		$user['sex'] = 'm';
		return User::query()->create($user)??false;

	}

	public function preparePassword(string $password): string
	{
		return md5($password . $this->salt);
	}

	public function randomPassword(): string
	{
		return ShortlinkService::create(8);

	}
}