<?php

namespace app\model;


use app\core\Auth;
use app\core\IUser;
use app\Repository\ImageRepository;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserYandex extends Model implements IUser
{
    use softDeletes;
    public $table = 'users_yandex';

    public $timestamps = true;
    protected $fillable = [
        'ya_id',
        'login',
        'client_id',
        'display_name',
        'real_name',
        'first_name',
        'last_name',
        'sex',
        'default_email',
        'emails',
        'birthday',
        'default_avatar_id',
        'is_avatar_empty',
        'default_phone',
        'psuid',
        'rights',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function rights(): Attribute
    {
        return Attribute::get(fn(string $rights) => explode(',', $rights));
    }

    public function getId():int
    {
        return $this->id;
    }
    public function can($rights = []): bool
    {
        $has = $this->hasRights($rights);
        $su  = Auth::isSU();
        return ($has || $su);
    }
    public function hasRights(array $rights): bool
    {
        return !!array_intersect($this->rights, $rights);
    }




}
