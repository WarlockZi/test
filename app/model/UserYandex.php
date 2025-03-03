<?php

namespace app\model;


use app\core\IUser;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserYandex extends Model implements IUser
{
    use softDeletes;

    public $table = 'user_yandex';


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

    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->using(RoleUserYandex::class)
            ->withTimestamps();

    }

    protected function rights(): Attribute
    {
        return Attribute::get(fn(string $rights) => explode(',', $rights));
    }

    public function avatar(): string
    {
        $href = "https://avatars.yandex.net/get-yapic/{$this->default_avatar_id}/islands-50";
        return $href;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function can($rights = []): bool
    {
        $has = $this->hasRights($rights);
        $su  = $this->isSU();
        return ($has || $su);
    }

    public function hasRights(array $rights): bool
    {
        return !!array_intersect($this->rights, $rights);
    }

    public function isOlya(): bool
    {
        return 'vitex018@yandex.ru' === $this->mail();
    }

    public function isSU(): bool
    {
        return env('SU_EMAIL') === $this->mail();
    }

    public function isAdmin(): bool
    {
        return $this->can(['role_admin']);
    }

    public function isEmployee(): bool
    {
        return $this->can(['role_employee']);
    }

    public function fi(): string
    {
        return $this->real_name;
    }

    public function mail(): string
    {
        return $this->default_email;
    }
}
