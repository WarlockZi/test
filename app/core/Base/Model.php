<?php

namespace app\core\Base;

use app\core\DB;
use app\view\widgets\menu\Menu;
use PHPMailer\PHPMailer\PHPMailer;

abstract class Model {

   protected $pdo;
   protected $sql;
   protected $table;
   protected $pk = 'id'; // Конвенция Первичный ключ по умолчанию будет 'id', но можно его переопределить

   public function __construct() {
      $this->pdo = DB::instance();
   }

   /**
    * очистка введенных данных
    */
   public function clean_data($str) {
      return strip_tags(trim($str));
   }

   public function findAll($table) {
      $sql = "SELECT * FROM " . $table ?: $this->table;
      return $this->pdo->query($sql);
   }

   public function del($table, $id) {
      $param[0] = $id;
      $sql = "DELETE FROM $table WHERE id = ?";
      return $this->insertBySql($sql, $param);
   }

   /**
    * Получить строку из таблицы table по полю field, где id искомый параметр<br/>
    * @param str $field <p>field поле, по которому ищем</p>
    * @param integer $id <p>$id значение (по умолч - id)</p>
    * @return array <p>строку таблицы</p>
    */
   public function findOne($id, $field = '') {
      $field = $field ?: $this->pk;
      $sql = "SELECT * FROM {$this->table} WHERE $field = ? LIMIT 1";
      return $this->pdo->query($sql, [$id]);
   }

   /**
    * Получить строку из таблицы table по полю field, где id искомый параметр<br/>
    * @param str $field <p>field поле, по которому ищем</p>
    * @param integer $id <p>$id значение (по умолч - id)</p>
    * @return array <p>строку таблицы</p>
    */
   public function findWhere($id, $field, $table) {

      $table = $table ?: $this->table;
      $field = $field ?: $this->pk;
      $sql = "SELECT * FROM {$table} WHERE $field = ?";
      return $this->pdo->query($sql, [$id]);
   }

   /**
    * Получить <br/>
    * @param str $field <p>field поле, по которому ищем</p>
    * @param integer $id <p>$id значение (по умолч - id)</p>
    * @return array <p>строку таблицы</p>
    */
   public function findBySql($sql, $params = []) {
      return $this->pdo->query($sql, $params);
   }

   public function insertBySql($sql, $params = []) {
      return $this->pdo->execute($sql, $params);
   }

   public function autoincrement($table, $db = 'vitex_test') {
      $params = [$db, $table];
      $sql = "SHOW TABLE STATUS FROM vitex_test LIKE '$table'";
      return $this->pdo->query($sql, $params)[0]['Auto_increment'];
   }

   public function getBreadcrumbs($category, $parents, $type) {
      if ($type=='category') {

      // в parents массив из адресной строки - надо получить aliases
      foreach ($parents as $key) {
         $params = [$key['name']];
         $sql = 'SELECT * FROM category WHERE name = ?';
         //если это категория, а ее не нашли вернем 404  ошибку
         if ($arrParents[] = $this->findBySql($sql, $params)[0]) {

         } else {
            http_response_code(404);
            include '../public/404.html';
            exit();
         }
      }
      }

      $breadcrumbs = "<a href = '/'>Главная</a>";

      foreach ($parents as $parent) {
         $breadcrumbs .= "<a href = '/{$parent['name']}'>{$parent['alias']}</a>";
      }
      if ($type == 'category') {
         return $breadcrumbs . "<span>{$category['alias']}</span>";
      }else{
         return $breadcrumbs . "<span>{$category['name']}</span>";

      }
   }

   public function send_result_mail($cache_path, $action) {

      $post = json_decode($_POST['param']);
      $pageCache = $post->pageCache;
      $file = md5(date(' d m - H i s'));
      $fileUTF8 = CACHE . $cache_path . $file . '.txt';
      $fileWin = mb_convert_encoding($fileUTF8, 'cp1251');
// ссылка присоединяется в форме письма  в строке require APP . '/view/Freetest/email.php';
      $httpRes = "http://" . $_SERVER['HTTP_HOST'] . PROJ . $action . $file;

      if (file_put_contents($fileWin, $pageCache)) {

         $userName = $post->name;
         $testName = $post->test_name;
         $questCnt = $post->questionCnt; //count($_SESSION['freetestData']) - 1; // один элемент это key_words
         $errorCnt = (int) $post->errorCnt;
         $errorSubj = $errorCnt == 0 ? 'СДАН' : "не сдан: $errorCnt ош из $questCnt";

         $mail = $this->getPhpMailer();

         try {
            $mail->SMTPDebug = 2;  // Enable verbose debug output
            $config = require CONFIG;
            $config = $config['Mailer'];
            if ($config['smtp_mode']) {
               $mail->isSMTP();                                      // Set mailer to use SMTP
               $mail->SMTPAuth = true;                               // Enable SMTP authentication
               $mail->Username = $config['smtp_username'];                 // SMTP username
               $mail->Password = $config['smtp_pass'];                           // SMTP password
               $mail->SMTPSecure = $config['smtp_SMTPSecure'];                            // Enable TLS encryption, `ssl` also accepted
               $mail->Port = $config['smtp_port'];
            };
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            //Recipients
            $mail->setFrom('vvoronik@yandex.ru', $userName);
            $mail->addAddress('vvoronik@yandex.ru', 'vvv');     // Add a recipient
            if (trim($userName) !== "Вороник Виталий Викторович") {
               $mail->addAddress('sno_dir@vitexopt.ru', 'SNO');
            };
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $errorSubj;

            ob_start();
            require APP . '/view/Freetest/email.php';
            $body = ob_get_clean();

            $mail->Body = $body;
            $mail->AltBody = "Название теста: $testName/r/n"
               . "От кого: $userName/r/n
                  Результат: $errorCnt ошибок из $questCnt
                  Ссылка на страницу с результатами: тут";

            $mail->send();
            echo 'Message has been sent';
         } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
         }
      };
   }

   /**
    * подключает PHPMailer
    */
   public function getPhpMailer() {

      require_once(ROOT . '/libs/PHPMailer/src/Exception.php');
      require_once(ROOT . '/libs/PHPMailer/src/OAuth.php');
      require_once(ROOT . '/libs/PHPMailer/src/PHPMailer.php');
      require_once(ROOT . '/libs/PHPMailer/src/SMTP.php');
      require_once(ROOT . '/libs/PHPMailer/src/POP3.php');

      return new PHPMailer(true);
   }

}
