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
	public $model = 'user';

	protected $fillable = [
		'name' => '',
		'confirm' => '0',
		'password' => 'gfasdf41(D{%',
	];


	public function __construct()
	{
		parent::__construct();
	}

	public static function can($user, $rights)
	{
		if (is_string($rights)){
			$rights = compact('rights');
		}
		return (array_intersect($rights, $user['rights'])||defined('SU'))??null;
	}

	public function findOne($id, $field = '')
	{
		if ($user = parent::findOne($id)) {
			$user['rights'] = explode(',', $user['rights']);
		}
		return $user??null;
	}

	public static function findOneWhere($field = '',$value = '')
	{
		if ($user = parent::findOneWhere($field, $value)) {
			$user['rights'] = explode(',', $user['rights']);
		}
		return $user??null;
	}


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
		$res = $this->findOneWhere('email',$email);
		if ($res) {
			return true;
		}
		return false;
	}

}
