<?php

// Настраиваем параметры cookie перед запуском сессии
session_set_cookie_params([
    'lifetime' => 0,           // До закрытия браузера
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'] ?? '',
    'secure' => isset($_SERVER['HTTPS']),  // Автоматически для HTTPS
    'httponly' => true,        // Защита от XSS
    'samesite' => 'Lax'        // Дополнительная защита от CSRF
]);

// Запускаем сессию только если она ещё не запущена
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Генерируем новый ID сессии для безопасности (опционально)
// session_regenerate_id(true);