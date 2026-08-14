<?php

use Illuminate\Support\Str;

define ('GUEST_COOKIE_NAME', 'vitex_guest_id');
define ('GUEST_COOKIE_TTL', 43200); // 30 дней в минутах → для setcookie() нужны СЕКУНДЫ!

if (!isset($_COOKIE[GUEST_COOKIE_NAME])) {
//    $guestId = Str::uuid()->toString()?? time().env('SALT');
    $guestId =  time().env('SALT');

    // ⚠️ Обратите внимание: TTL в СЕКУНДАХ, а не минутах
    setcookie(GUEST_COOKIE_NAME, $guestId, [
        'expires'  => time() + 2592000,
        'path'     => '/',
        'domain'   => '',
        'secure'   => true,       // HTTPS обязателен
        'httponly'  => false,      // JS должен читать этот cookie
        'samesite' => 'Lax',      // Работает с OAuth-редиректами
    ]);

    $_COOKIE[GUEST_COOKIE_NAME] = $guestId;
}