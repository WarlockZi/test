<?php

namespace app\core;

use app\model\User;
use Symfony\Component\Validator\Validation;

class Request
{
   private function cleanRequest($textrequest): string
   {
      $textrequest = trim($textrequest);
      // Фиксируем атаки
      if (preg_match("/script|http|<|>|<|>|SELECT|UNION|UPDATE|INSERT|exe|exec|tmp/i", $textrequest)) {
//         writelog('hack', date("y.m.d H:m:s")."\t".$_SERVER['REMOTE_ADDR']."\t".$textrequest);
         $textrequest = '';
      }
      // Очищаем опасные запросы
      if (preg_match("/[=,:;\s]/", $textrequest)) {
         $textrequest = '';
      }
      return $textrequest;
   }

   public function checkLoginCredentials(array $ajax): array
   {
      $errors = [];
      if (!isset($ajax['email']))
         $errors[] = 'Заполните почту';
      if (!isset($ajax['password']))
         $errors[] = 'Заполните пароль';
      if (!$this->checkEmail($ajax['email']))
         $errors[] = 'Неверный формат email';
      if (!$this->checkPassword($ajax['password']))
         $errors[] = "Пароль не должен быть короче 6-ти символов";
      return  $errors;
   }
   private function checkPassword(string $password):bool
   {
      $password = $this->cleanRequest($password);
      if (strlen($password) >= 6) {
         return true;
      }
      return false;
   }

   private function  checkEmail(string $email):bool
   {
      $email = $this->cleanRequest($email);
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
         return true;
      }
      return false;
   }


}