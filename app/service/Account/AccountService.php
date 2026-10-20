<?php

namespace app\service\Account;

use app\repository\AccountRepository;
use app\service\AuthService\AuthService;
use app\service\AuthService\IUser;

class AccountService
{
    private AccountRepository $repo;
    public function __construct()
    {
        $this->repo = new AccountRepository();
    }

    public function mergeAccount(IUser $user)
    {
        $guestCookie = $_COOKIE['vitex_guest_id'] ?? null;
        $accRepo     = $this->repo;
        return $accRepo->mergeAcc($guestCookie, $user);
    }
    public function accountField(): array
    {
        $account_id = AuthService::accountId();
        if ($account_id) return ['account_id', $account_id];
        return ['vitex_guest_id', $_COOKIE['vitex_guest_id']];
    }

}