<?php

use \PHPMailer\PHPMailer\PHPMailer;

namespace app\model;

class Mail {

   public function send_mail($email, $tema, $mail_body, $headers) {
      require_once(ROOT . '/libs/PHPMailer/src/Exception.php');
      require_once(ROOT . '/libs/PHPMailer/src/OAuth.php');
      require_once(ROOT . '/libs/PHPMailer/src/PHPMailer.php');
      require_once(ROOT . '/libs/PHPMailer/src/SMTP.php');
      require_once(ROOT . '/libs/PHPMailer/src/POP3.php');

      $config = require CONFIG;
      if ($_SERVER['SERVER_NAME'] == 'vitexopt.ru') {
         $config = $config['Mailer_vitex'];
      } else {
         $config = $config['Mailer_openServer'];
      }
      $mail = new PHPMailer(true);
      try {
         $mail->SMTPDebug = 2;  // Enable verbose debug output
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
         $mail->setFrom('vitexopt@vitexopt.ru', 'vitexopt@vitexopt.ru');
         $mail->addAddress($email);     // Add a recipient
         $mail->isHTML(true);                                  // Set email format to HTML
         $mail->Subject = $tema;
         $mail->Body = $mail_body;
         $mail->AltBody = "Ссылка на страницу с результатами: тут";

         $mail->send();
         echo 'Message has been sent';
      } catch (Exception $e) {
         echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
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

         $mail = new PHPMailer(TRUE);

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

}
