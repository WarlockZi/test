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
		'email' => '',
		'password' => 'gfasdf41(D{%',
		'name' => '',
		'surName' => '',
		'middleName' => '',
		'confirm' => '0',
		'rights' => 'user_update',
//		'birthDate'=>'1970-01-02',
//		'hired'=>date('Y/m/d'),
//		'fired'=>'',
		'sex'=>'f',
	];


	public function __construct()
	{
		parent::__construct();
	}

	public static function can(array $user, $rights=[])
	{
		if (is_string($rights)&&$rights){
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
			$user['post_id'] = explode(',', $user['post_id']);
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
