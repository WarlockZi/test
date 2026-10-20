<?php

$GUEST_COOKIE_NAME = 'vitex_guest_id';
$guestId = $_COOKIE[$GUEST_COOKIE_NAME]?? bin2hex(random_bytes(32));
$expire = 33 * 24 * 60 * 60 * 1000; //33 дня

if (!isset($_COOKIE[$GUEST_COOKIE_NAME])) {
    setCartCookie($GUEST_COOKIE_NAME, $guestId, $expire);
} else {
    if (date("j") == '14') {// revalidate expire cookie if today is 14th
        setCartCookie($GUEST_COOKIE_NAME, $guestId, $expire);
    }
}

function setCartCookie($GUEST_COOKIE_NAME, $guestId, $expire): void
{
    setcookie($GUEST_COOKIE_NAME, $guestId, [
        'expires' => $expire, // 30 дней
        'path' => '/',
        'domain' => '',
        'secure' => true,       // HTTPS обязателен
        'httponly' => true,      // JS не должен читать
        'samesite' => 'Lax',
    ]);

    $_COOKIE[$GUEST_COOKIE_NAME] = $guestId;
}
