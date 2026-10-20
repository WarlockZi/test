<?php

namespace app\action;

use app\model\User;
use app\service\PasswordGenerator\PasswordGeneratorService;

class AuthActions
{
    public function checkLoginPasswordConfirm($validated): ?User
    {
        $user = User::where('email', $validated['email'])->with('account')->with('role')->first();

        if (!$user) response()->json([
            'error' => 'email не найден',
            'popup' => 'Пройдите регистрацию']);

        if (!$user->confirm) response()->json([
            'error' => 'Зайдите на почту чтобы подтвердить регистрацию',
            'popup' => 'Зайдите на почту чтобы подтвердить регистрацию',]);
        if ($user->password !== PasswordGeneratorService::hashPassword($validated['password'])) {
            if (!$user->isSU()) {
                response()->json(['error' => 'Не верный email или пароль']);
            }
        }
        return $user;
    }
}