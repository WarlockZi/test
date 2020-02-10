<?

namespace app\model;

use app\core\DB;
use app\core\Base\Model;

/**
 * Класс User - модель для работы с пользователями
 */
class User extends Model {

   public $table = 'users';

   public function __construct() {
      parent::__construct();
   }

   public function confirm($hash) {

      $sql = '
            UPDATE users
            SET confirm= "1"
            WHERE hash = ?
            ';

      $params = [$hash];
      $result = $this->insertBySql($sql, $params);

      if ($result) {
         return "Вы успешно подтвердили свой E-mail.";
      } else {
         return "Не верный код подтверждения регистрации";
      }
   }

   public function getPassword($email) {

      $email = $this->clean_data($email);
      $sql = "
            SELECT id
            FROM {$this->table}
            WHERE email = ?
            ";
      $params = [$email];
      $userId = $this->findBySql($sql, $params)[0]['id'];
      if (!$userId) {
         return "Пользователя с таким e-mail нет";
      }
      if ($userId) {
         $str = "23456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";

         $pass = '';
         for ($i = 0; $i < 6; $i++) {
            $x = mt_rand(0, (strlen($str) - 1));
            if ($i != 0) {
               if ($pass[strlen($str) - 1] == $str[$x]) {
                  $i--;
                  continue;
               }
            }
            $pass .= $str[$x];
         }
         $md5pass = md5($pass);
         $sql = "
                    UPDATE {$this->table}
                    SET password = ?
                    WHERE id = ?
                ";
         $params = [$md5pass, $userId];
         $result = $this->insertBySql($sql, $params);
         if (!$result) {
            return "Не удалось обновить новый пароль в базе";
         }
         $headers = "Content-Type:text/plain;charset=utf8";
         $headers .= "Письмо из системы тестирования <vvoronik@yandex.ru> \r\n";
         $subject = 'new password';
         $mail_body = "Ваш новый пароль: " . $pass;
         mail($email, $subject, $mail_body, $headers);
         return true;
      } else {
         return "Пользователя  с таким почтовым ящиком нет";
      }
   }

   public function returnPass() {

      if (isset($_POST['email'])) { //отправили форму
         $msg = $this->getPassword($_POST['email']);

         if ($msg === TRUE) {
            $_SESSION['msg'] = "Новый пароль выслан Вам на почту";
            header("Location:" . PROJ . "/user/login");
         } else {
            $_SESSION['msg'] = $msg;
         }
      } else {                      //не  отпарвляли форму
         $_SESSION['msg'] = '';
      }
   }

   /**
    * Редактирование данных пользователя
    * @param integer $id <p>id пользователя</p>
    * @param string $name <p>Имя</p>
    * @param string $password <p>Пароль</p>
    * @return boolean <p>Результат выполнения метода</p>
    */
//   public function update($arr) {
////        $password = md5($arr['password']);
//      $sql = "UPDATE users SET  email = ?, name = ?, confirm = ?, surName = ?, middleName = ?, birthDate = ?, hired = ?, fired = ?, phone = ?, rights  =? WHERE id = ?";
//
//      $params = [$arr['email'], $arr['name'], (int) $arr['conf'], $arr['sName'], $arr['mName'], $arr['bday'] ?: NULL, $arr['hired'] ?: NULL, $arr['fired'] ?: NULL, $arr['phone'], $arr['rights'], $arr['id']];
//      return $this->insertBySql($sql, $params);
//   }

   /**
    * Проверяем существует ли пользователь с заданными $email и $password
    * @param string $email <p>E-mail</p>
    * @param string $password <p>Пароль</p>
    * @return mixed : integer user id or false
    */
   public function getUserByEmail($email, $password) {

      $password = md5($password);

      $sql = "SELECT * FROM {$this->table} WHERE email = ? AND password = ?";
      try {
         $user = $this->findBySql($sql, [$email, $password]);
      } catch (Exception $exc) {
         echo $exc->getTraceAsString();
      }
      if ($user) {
         $user = $user[0];
         // Если запись существует и подтверждена, возвращаем id пользователя
         if ($user['confirm'] == 1) {
            return $user;
            // Не подтверждена, возвращаем NULL
         } elseif ($user['confirm'] == 0) {
            return NULL;
         }
      }
      //  Такого пользователя нет возвращаем FALSE
      return false;
   }

   /**
    * Запоминаем пользователя
    * @param integer $userId <p>id пользователя</p>
    * @return
    */
   public function setAuth($user) {
      // Записываем идентификатор пользователя в сессию
       if (!isset($_SESSION['id']) || $_SESSION['id']='') {
           $_SESSION['id'] = (int)$user['id'];
       }
   }

   /**
    * Проверяет имя: не меньше, чем 2 символа
    * @param string $name <p>Имя</p>
    * @return boolean <p>Результат выполнения метода</p>
    */
   public function checkName($name) {
      if (strlen($name) >= 2) {
         return true;
      }
      return false;
   }

   /**
    * Проверяет телефон: не меньше, чем 10 символов
    * @param string $phone <p>Телефон</p>
    * @return boolean <p>Результат выполнения метода</p>
    */
   public function checkPhone($phone) {
      if (strlen($phone) >= 10) {
         return true;
      }
      return false;
   }

   /**
    * Проверяет имя: не меньше, чем 6 символов
    * @param string $password <p>Пароль</p>
    * @return boolean <p>Результат выполнения метода</p>
    */
   public function checkPassword($password) {
      if (strlen($password) >= 6) {
         return true;
      }
      return false;
   }

   /**
    * Проверяет email
    * @param string $email <p>E-mail</p>
    * @return boolean <p>Результат выполнения метода</p>
    */
   public static function checkEmail($email) {
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
         return true;
      }
      return false;
   }

   /**
    * Проверяет не занят ли email другим пользователем
    * @param type $email <p>E-mail</p>
    * @return boolean <p>Результат выполнения метода</p>
    */
   public function checkEmailExists($email) {

      $res = $this->findOne($email, 'email');
      if (count($res)) {
         return $res;
      }
      return $res;
   }

   /**
    * Возвращает пользователя с указанным id
    * @param integer $id <p>id пользователя</p>
    * @return array <p>Массив с информацией о пользователе</p>
    */
   public function getUser($id) {


      $res = $this->findOne($id, 'id');
      if ($res) {
         $res['rights'] = explode(",", $res['rights']);
         return $res;
      }
      return false;
   }

   public function getRights() {


      $res = $this->findAll('user_rights');
      if ($res) {
//         $res['rights'] = explode(",", $res['rights']);
         return $res;
      }
      return false;
   }

   /**
    * Возвращает пользователя с указанным hash
    * @param integer $hash <p>hash пользователя</p>
    * @return array <p>Массив с информацией о пользователе</p>
    */
   public function getUserByHash($hash) {

      $sql = "SELECT * FROM {$this->table} WHERE hash = ?";

      if (isset($this->findBySql($sql, [$hash])[0])) {
         $user = $this->findBySql($sql, [$hash])[0];
         if ($user) {
            // Если запись существует и подтверждена, возвращаем id пользователя
            return $user;
         }
      }
      //  Такого пользователя нет возвращаем FALSE
      return false;
   }
}
