<?php


namespace app\Repository;


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

   public function randomPassword(): string
   {
      return ShortlinkService::create(8);
   }

   public function returnPassword(array $data): array
   {
      return User::where('email', $data['email'])
         ->select('id', 'password', 'email')
         ->get()[0]
         ->toArray();
   }

   public function findByMail(string $mail):User|null
   {
      return User::where('email', $mail)->first();
   }

   public function createUser(array $req):Model
   {
      $user['email'] = $req['email'];
      $user['password'] = $this->preparePassword($req['password']);
      $user['hash'] = md5(microtime());
      $user['rights'] = 'user_update';
      $user['sex'] = 'm';
      return User::create($user);
   }
}