<?

namespace app\model;

use app\Repository\ImageRepository;


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
		'hash' => '',
		'confirm' => '0',
		'rights' => 'user_update',
		'post_id' => 0,
    'birthDate'=>'1970-01-02',
    'hired'=>'1970-01-02',
    'fired'=>'1970-01-02',
		'sex' => 'f',
	];

	public static function avatar(array $user): string
	{
		if (isset($user['avatar'])){
			return $user['avatar'];
		}

		return $user['sex'] === 'f'
			? ImageRepository::getImg('/pic/ava_female.jpg')
			: ImageRepository::getImg('/pic/ava_male.png');
	}

	public function __construct()
	{
		parent::__construct();
	}

	public static function can(array $user, $rights = []): bool
	{
		if (is_string($user['rights'])){
			$user['rights'] = explode(',',$user['rights']);
		}
		if (is_string($rights) && $rights) {
			$rights = compact('rights');
		}
		return (
				array_intersect($rights, $user['rights'])
				|| defined('SU')
				|| array_intersect(['role_admin'], $user['rights']))
			?? false;
	}

	public function findOne($id, $field = '')
	{
		if ($user = parent::findOne($id)) {
			$user['rights'] = explode(',', $user['rights']);
		}
		return $user ?? null;
	}

	public static function findOneWhere($field = '', $value = '')
	{
		if ($user = parent::findOneWhere($field, $value)) {
			$user['rights'] = explode(',', $user['rights']);
			$post_id = is_array($user['post_id'])
				? explode(',', $user['post_id'])
				: Null;
			$user['post_id'] = $post_id;
		}
		return $user ?? null;
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
		$res = $this->findOneWhere('email', $email);
		if ($res) {
			return true;
		}
		return false;
	}

}
