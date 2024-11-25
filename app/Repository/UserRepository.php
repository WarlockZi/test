<?php


namespace app\Repository;


use app\model\RoleUser;
use app\model\User;
use app\Services\ShortlinkService;
use Illuminate\Database\Eloquent\Model;

class UserRepository
{
    protected string $salt;

    public function __construct()
    {
        $this->salt = "popiyonovacheesa";
    }

    public function preparePassword(string $password): string
    {
        return md5($password . $this->salt);
    }

    public function changePassword(User $user, string $newPassword): void
    {
        $user->update(['password' => $newPassword]);
    }

    public function randomPassword(): string
    {
        return ShortlinkService::create(8);
    }

    public function getByEmail(string $email): User
    {
        return User::where('email', $email)->select('id', 'password', 'email')->first();
    }

    public function findByMail(string $mail): User|null
    {
        return User::where('email', $mail)->first();
    }

    public function changeRole(array $req): void
    {
        $userId   = $req['id'];
        $roleId   = $req['relation']['fields']['role_id'];
        $userRole = [
            'user_id' => $userId,
            'role_id' => $roleId,
        ];
        RoleUser::query()
            ->updateOrCreate(
                [
                    'user_id' => $userId,
                ],
                $userRole);
    }

    public function createUser(array $req): Model
    {
        $user['email']    = $req['email'];
        $user['password'] = $this->preparePassword($req['password']);
        $user['hash']     = md5(microtime());
        $user['rights']   = 'user_update';
        $user['sex']      = 'm';
        return User::create($user);
    }
}