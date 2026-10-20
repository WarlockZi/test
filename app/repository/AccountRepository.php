<?php

namespace app\repository;

use app\model\Account;
use app\model\User;
use app\model\UserYandex;
use app\service\AuthService\IUser;

class AccountRepository
{

    public function mergeAcc(string $guestId, IUser $user)
    {
        [$users, $userYandex] = $this->getAffiliatedUsers($guestId, $user);
        $existed_users_account = $this->getExistedUsersAccount($users, $userYandex);
        if (!$existed_users_account) {
            $existed_users_account = Account::create()->id;
        }
        $this->setAccountId($users, $userYandex, $existed_users_account);
        return $existed_users_account;
    }

    private function setAccountId($users, $usersYandex, $accountId = null): void
    {
        $allUsers = $users->merge($usersYandex);
        $allUsers->each(function ($user) use ($accountId) {
            $user->account_id = $accountId;
            $user->save();
        });
    }
    private function getExistedUsersAccount($users, $usersYandex)
    {
        $found= $users->merge($usersYandex)->firstWhere('account_id', '!=', null);
        return $found? $found->account_id: null;
    }
    private function getAffiliatedUsers(string $guestId, IUser $user){
        $users = User::where('email', $user->mail())
            ->orWhere('guest_id', $guestId)->distinct()->get();

        $usersYandex = UserYandex::where('default_email', $user->mail())
            ->orWhere('guest_id', $guestId)->distinct()->get();
        return [$users, $usersYandex];

    }
}