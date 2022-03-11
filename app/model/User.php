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

	public static function can($user, $right)
	{
//		$user = App::$app->user->findOne($user['id']);
		return in_array($right, $user['rights']);
	}

	public function findOne($id, $field = '')
	{
		if ($user = parent::findOne($id)) {
			$user['rights'] = explode(',', $user['rights']);
		}
		return $user??null;
	}

//	public function getUserByEmail($email, $password)
//	{
//		$password = md5($password);
//
//		$sql = "SELECT * FROM {$this->table} WHERE email = ? AND password = ?";
//		try {
//			$user = $this->findBySql($sql, [$email, $password]);
//		} catch (Exception $exc) {
//			echo $exc->getTraceAsString();
//		}
//		if ($user) {
//			$user = $user[0];
//			if ($user['confirm'] == 1) {
//				return $user;
//			} elseif ($user['confirm'] == 0) {
//				return NULL;
//			}
//		}
//		return false;
//	}

	public function checkName($name)
	{
		if (strlen($name) >= 2) {
			return true;
		}
		return false;
	}

	public function checkPhone($phone)
	{
		if (strlen($phone) >= 10) {
			return true;
		}
		return false;
	}


	public static function checkPassword($password)
	{
		if (strlen($password) >= 6) {
			return true;
		}
		return false;
	}

	public static function checkEmail($email)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return true;
		}
		return false;
	}


	public function checkEmailExists($email)
	{
		$res = $this->findOne($email, 'email');
		if ($res) {
			return true;
		}
		return false;
	}

}
