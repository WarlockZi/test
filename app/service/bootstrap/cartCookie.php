<?php

$GUEST_COOKIE_NAME='vitex_guest_id';

if (!isset($_COOKIE[$GUEST_COOKIE_NAME])) {
    $guestId =  session_id();

    // ⚠️ Обратите внимание: TTL в СЕКУНДАХ, а не минутах
    setcookie($GUEST_COOKIE_NAME, $guestId, [
        'expires'  => time() + 2592000,
        'path'     => '/',
        'domain'   => '',
        'secure'   => true,       // HTTPS обязателен
        'httponly'  => false,      // JS должен читать этот cookie
        'samesite' => 'Lax',      // Работает с OAuth-редиректами
    ]);

    $_COOKIE[$GUEST_COOKIE_NAME] = $guestId;
}