<?

namespace app\model;

use app\model\Mail;
use app\core\App;
use app\core\DB;
use app\model\Model;
use app\view\View;


class User extends Model
{

	public $table = 'users';

	public function __construct()
	{
		parent::__construct();
	}

	public function confirm($hash)
	{
		$sql = 'UPDATE users SET confirm= "1" WHERE hash = ?';
		$params = [$hash];
		$result = $this->insertBySql($sql, $params);

		if ($result) {
			$_SESSION['id'] = $this->autoincrement() - 1;
			$this->user = App::$app->user->get($_SESSION['id']);

			return "Вы успешно подтвердили свой E-mail.";
		} else {
			return "Не верный код подтверждения регистрации";
		}
	}

	public function returnPass($email)
	{
		$sql = "SELECT id FROM {$this->table} WHERE email = ?";
		$params = [$email];
		$id = $this->findBySql($sql, $params)[0]['id'];

		if ($id) {
			$pass = substr(md5(rand()), 0, 7);;
			$new_pass = md5($pass);
			$sql = "UPDATE {$this->table} SET password = ? WHERE id = ?";
			$params = [$new_pass, $id];
			if ($this->insertBySql($sql, $params)) {
				$subject = 'Новый пароль';
				$mail_body = "Ваш новый пароль: " . $pass;
				Mail::send_mail([$email], $subject, $mail_body);
			}
		} else {
			exit(json_encode(["smg" => "Пользователя с таким e-mail нет"]));
		}

	}

	public
	function getUserByEmail($email, $password)
	{
		$password = md5($password);

		$sql = "SELECT * FROM {$this->table} WHERE email = ? AND password = ?";
		try {
			$user = $this->findBySql($sql, [$email, $password]);
		} catch (Exception $exc) {
			echo $exc->getTraceAsString();
		}
		if ($user) {
			$user = $user[0];
			if ($user['confirm'] == 1) {
				return $user;
			} elseif ($user['confirm'] == 0) {
				return NULL;
			}
		}
		return false;
	}

	public
	function checkName($name)
	{
		if (strlen($name) >= 2) {
			return true;
		}
		return false;
	}

	public
	function checkPhone($phone)
	{
		if (strlen($phone) >= 10) {
			return true;
		}
		return false;
	}


	public
	static function checkPassword($password)
	{
		if (strlen($password) >= 6) {
			return true;
		}
		return false;
	}

	public
	static function checkEmail($email)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return true;
		}
		return false;
	}


	public
	function checkEmailExists($email)
	{
		$res = $this->findOne($email, 'email');
		if ($res) {
			return true;
		}
		return false;
	}


	public
	function get($id)
	{
		$res = $this->findOne($id, 'id');
		if ($res) {
			$res['rights'] = explode(",", $res['rights']);
			return $res;
		}
		return false;
	}

	public
	function getRights()
	{
		$res = $this->findAll('user_rights');
		if ($res) {
			return $res;
		}
		return false;
	}

	public
	function getUserByHash($hash)
	{
		$sql = "SELECT * FROM {$this->table} WHERE hash = ?";

		if (isset($this->findBySql($sql, [$hash])[0])) {
			$user = $this->findBySql($sql, [$hash])[0];
			$user['rights'] = explode(',', $user['rights']);
			if ($user) {
				return $user;
			}
		}
		return false;
	}
}
