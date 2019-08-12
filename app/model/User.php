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

    public function getRights() {
        $this->table = 'user_rights';
        return $this->findAll('user_rights');
    }

    public function getUserRightsSet($userId) {

        $sql = "SELECT u.id, u.surName, ur.name, ur.id FROM `users` AS u"
                . " LEFT JOIN `users_rights_set` AS urs"
                . " ON urs.parent=u.id"
                . " LEFT JOIN `user_rights` AS ur"
                . " ON ur.id=urs.name"
                . " WHERE u.id=?"
                . "";
        $params = [$userId];
        return $this->findBySql($sql, $params);
    }

    public function getUserWithRightsSet($id) {

        $user = $this->getUser($id);
        $user_rights_set = $this->getUserRightsSet($id);
        foreach ($user_rights_set as $k) {
            $user['rights_set'][$k['id']] = $k['name'];
        }
        return $user;
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
    public function update($arr) {
//        $password = md5($arr['password']);
        $sql = "UPDATE users SET  email = ?, name = ?, confirm = ?, surName = ?, middleName = ?, birthDate = ?, hired = ?, fired = ?, phone = ?, rights  =? WHERE id = ?";

        $params = [$arr['email'], $arr['name'], (int)$arr['conf'], $arr['sName'], $arr['mName'], $arr['bday']?:NULL, $arr['hired']?:NULL, $arr['fired']?:NULL,$arr['phone'], $arr['rights'], $arr['id']];
        return $this->insertBySql($sql, $params);
    }

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
        $_SESSION['id'] = (int) $user['id'];
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
            return $res[0];
        }
        return $res;
    }

    /**
     * Проверяет не занят ли email другим пользователем
     * @param type $email <p>E-mail</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
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

//         $userName = $post->name;
//         $testName = $post->test_name;
//         $questCnt = count($_SESSION['freetestData']) - 1; // один элемент это key_words
//         $errorCnt = (int) $post->errorCnt;
//         $errorSubj = $errorCnt == 0 ? 'СДАН' : "не сдан: $errorCnt ош из $questCnt";

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
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
//            if (trim($userName) !== "Вороник Виталий Викторович") {
//               $mail->addAddress('sno_dir@vitexopt.ru', 'SNO');
//            };
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $tema;

//            ob_start();
//            require APP . '/view/Freetest/email.php';
//            $body = ob_get_clean();

            $mail->Body = $mail_body;
            $mail->AltBody = "Ссылка на страницу с результатами: тут";

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
//      };
    }

    /**
     * Возвращает пользователя с указанным id
     * @param integer $id <p>id пользователя</p>
     * @return array <p>Массив с информацией о пользователе</p>
     */
    public function getUser($id) {


        $res = $this->findOne($id, 'id');
        if ($res) {
            return $res[0];
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

    /**
     * Возвращает массив прав пользователя с указанным id
     * @param obj $user <p>obj пользователя</p>
     * @return array <p>Массив с информацией о правах</p>
     */
    //public function getUserRights($user) {
    //
   //    $userEmail = $user['email'];
    //    $sql = 'SELECT rightId FROM users WHERE email = ?';
    //	$rightId = $this->findBySql($sql, [$userEmail]);
    //
    //    // Разбиваем строку с запятыми получ индексированный массив
    //    $indexArrayOfStr = explode(',', $rightId[0]);
    //    // Преобразуем инд массив в числа
    //    $indexArrayOfNums = array_map(create_function('$value', 'return (int)$value;'), $indexArrayOfStr);
    //	foreach ($indexArrayOfNums as $k => $v){
    //        $sql = 'SELECT id, nameEn FROM rights WHERE id = ?';
    //		$arrRights[] = $this->findBySql($sql, [$v]);
    //	}
    //
    //    return $arrRights;
    //}
    //
    ///**
    // * Возвращает массив прав пользователя с указанным id
    // * @param obj $user <p>obj пользователя</p>
    // * @return array <p>Массив с информацией о правах</p>
    // */
    //public function isUsersRight($right, $user) {
    //    $rights = self::getUserRights($user);
    //    if (in_array($right, $rights)) {
    //        return true;
    //    }
    //}
}
