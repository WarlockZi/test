<?php

namespace app\core;

use app\model\User;

class Auth
{
   protected static array $user = [];

   public static function validateToken(array $data): bool
   {
      if (!$data || !isset($data['token']) || !$data['token']) return false;
      if (!$_SESSION['token'] === $data['token']
      ) {
         unset($data['token']);
         return true;
      }
      return false;
   }

   public static function setToken(): string
   {
      return $_SESSION['token'] = session_id();
   }

   public static function checkAuthorized(array $user, array $rights): void
   {
      if (!User::can($user, $rights)) {
         header("Location:/auth/unautherized");
      }
   }

   public static function getUser(): array
   {
      return self::$user;
   }


   public static function setAuth(array $user): void
   {
      $_SESSION['id'] = $user['id'];
   }

   public static function setUser(User $mockuser): void
   {
      self::$user = $mockuser->toArray();
   }

   public static function getAuth(): User|null
   {
      if (isset($_SESSION['id']) && $_SESSION['id']) {
         $user = User::find($_SESSION['id']);

         self::$user = $user ? $user->toArray() : null;
         return $user;
      }
      return null;
   }

   public static function isAdmin(): bool
   {
      $user = self::getUser();
      if (User::can($user, ['role_admin'])) {
         return true;
      }
      return false;
   }

   public static function isAuthed(): bool
   {
      return !!self::getUser();
   }

   public static function authorize(Route $route): array
   {
      if (AuthValidator::needsNoAuth($route)) {
         return [];//no user
      }

      $user = self::getUser();
      if (!$user) {
         header("Location:/auth/login");
         exit();
      }

      self::setAuth($user);
      if (!$user['confirm'] == "1") {
         $route->setError('Чтобы получить доступ, зайдите на рабочую почту, найдите письмо "Регистрация VITEX" и перейдите по ссылке в письме.');
         header("Location:/auth/noconfirm");
         exit();
      }

      if ($user['email'] === $_ENV['SU_EMAIL']) {
         define('SU', true);
      }
      return $user;
   }
}

