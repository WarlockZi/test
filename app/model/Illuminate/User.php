<?

namespace app\model\illuminate;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{
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
//		'birthDate'=>'1970-01-02',
//		'hired'=>date('Y/m/d'),
//		'fired'=>'',
		'sex' => 'f',
	];

	public function rights(){
		return $this->hasMany(Right::class);
	}


}
