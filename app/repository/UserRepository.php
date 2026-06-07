<?php


namespace app\repository;


use app\model\RoleUser;
use app\model\User;
use app\service\PasswordGenerator\PasswordGeneratorService;
use Illuminate\Database\Eloquent\Model;

class UserRepository
{

    public function changePassword(User $user, string $newPassword): void
    {
        $user->update(['password' => $newPassword]);
    }

    public function getByPass(string $password): User
    {
        return User::where('password', $password)->first();
    }


    public function getByEmail(string $email): ?User
    {
        return User::where('email', $email)
            ->select('id', 'password', 'email')
            ->first();
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
            ->updateOrCreate(['user_id' => $userId,],$userRole);
    }

    public function createUser(array $req): Model
    {
        $user['email']    = $req['email'];
        $user['password'] = PasswordGeneratorService::hashPassword($req['password']);
        $user['hash']     = md5(microtime());
        $user['rights']   = 'user_update';
        $user['sex']      = 'm';
        return User::create($user);
    }
}