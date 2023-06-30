<?

namespace app\model;


use app\Repository\ImageRepository;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	public $timestamps = true;
	protected $fillable = [
		'email', 'password',
		'name',
		'surName',
		'middleName',
		'hash',
		'confirm',
		'rights',
		'post_id',
		'birthDate',
		'hired',
		'fired',
		'sex',
		'phone',
	];

	public function rights()
	{
		return $this->hasMany(Right::class);
	}

	public function fio()
	{
		return "{$this->surName} {$this->name} {$this->middleName}";
	}

	public function fi()
	{
		return "{$this->surName} {$this->name}";
	}

	public static function avatar(array $user): string
	{
		if (isset($user['avatar'])) {
			return $user['avatar'];
		}

		return $user['sex'] === 'f'
			? ImageRepository::getImg('/pic/srvc/main/ava_female.jpg')
			: ImageRepository::getImg('/pic/srvc/main/ava_male.png');
	}

	public static function can(array $user, $rights = []): bool
	{
		if (!$user) return false;
		if (is_string($user['rights'])) {
			$user['rights'] = explode(',', $user['rights']);
		}

		$has = self::hasRights($user, $rights);
		$su = self::isSu();

		return ($has || $su);
	}

	public static function isAdmin(array $user): bool
	{
		if (is_string($user['rights'])) {
			$user['rights'] = explode(',', $user['rights']);
		}
		return !!array_intersect(['role_admin'], $user['rights']);
	}

	public static function isEmployee(array $user): bool
	{
		if (!$user) return false;
		if (is_string($user['rights'])) {
			$user['rights'] = explode(',', $user['rights']);
		}
		return !!array_intersect(['role_employee'], $user['rights']);
	}

	public static function isSu(): bool
	{
		return defined('SU');
	}

	public static function hasRights(array $user, array $rights): bool
	{
		return !!array_intersect($user['rights'], $rights);
	}

	public static function checkPassword(string $password)
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


}
