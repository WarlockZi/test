<?php

namespace app\model;


use app\core\Auth;
use app\core\IUser;
use app\Repository\ImageRepository;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements IUser
{
    use softDeletes;

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
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    protected function rights(): Attribute
    {
        return Attribute::get(fn(string $rights) => explode(',', $rights));
    }


    public function fio(): string
    {
        return "{$this->surName} {$this->name} {$this->middleName}";
    }
    public function mail(): string
    {
        return $this->email;
    }
    public function fi(): string
    {
        return "{$this->surName} {$this->name}";
    }

    public function avatar(): string
    {
        return $this['sex'] === 'f'
            ? ImageRepository::getImg('/pic/srvc/main/ava_female.jpg')
            : ImageRepository::getImg('/pic/srvc/main/ava_male.png');
    }

    public function can($rights = []): bool
    {
        $has = $this->hasRights($rights);
        $su  = Auth::isSU();
        return ($has || $su);
    }

    public function isEmployee(): bool
    {
        return $this->hasRights(['role_employee']);
    }

    public function hasRights(array $rights): bool
    {
        return !!array_intersect($this->rights, $rights);
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function isOlya(): bool
    {
        return 'vitex018@yandex.ru' === $this->mail();
    }
    public function isSU(): bool
    {
        return $_ENV['SU_EMAIL'] === $this->mail();
    }
    public function isAdmin(): bool
    {
        return $this->can(['role_admin']);
    }
}
