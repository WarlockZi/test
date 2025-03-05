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
        return Attribute::get(fn(string|null $rights) => !empty($rights) ? explode(',', $rights) : []);
    }

    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->using(RoleUser::class);
    }


    public function can($rights = []): bool
    {
        $has     = $this->hasRights($rights);
        $hasRole = $this->hasRoles($rights);
        $su      = Auth::isSU();
        $admin   = Auth::userIsAdmin();
        return ($has || $su || $admin || $hasRole);
    }

    public function hasRoles(array $rights): bool
    {
        foreach ($rights as $right) {
            if (str_starts_with($right, 'role_')) {
                if (!!Auth::getUser()->role->firstWhere('name', $right) === false) return false;
            }
        }
        return true;
    }


    public
    function fio(): string
    {
        $surname    = $this->surName ?? '*';
        $name       = $this->name ?? '*';
        $middleName = $this->middleName ?? '*';
        return "{$surname} {$name} {$middleName}";
    }

    public
    function mail(): string
    {
        return $this->email;
    }

    public
    function fi(): string
    {
        $surname = $this->surName ?? '*';
        $name    = $this->name ?? '*';
        return "{$surname} {$name}";
    }

    public
    function avatar(): string
    {
        return $this['sex'] === 'f'
            ? ImageRepository::getImg('/pic/srvc/main/ava_female.jpg')
            : ImageRepository::getImg('/pic/srvc/main/ava_male.png');
    }


    public
    function hasRights(array $rights): bool
    {
        return !!array_intersect($this->rights, $rights);
    }

    public
    function getId(): int
    {
        return $this->id;
    }

    public
    function isOlya(): bool
    {
        return 'vitex018@yandex.ru' === $this->mail();
    }

    public
    function isSU(): bool
    {
        return getenv('SU_EMAIL') === $this->mail();
    }

    public
    function isAdmin(): bool
    {
        return !!$this->role->firstWhere('name', 'role_admin');
    }

    public
    function isEmployee(): bool
    {
        return !!$this->role->firstWhere('name', 'role_employee');
//        return $this->role->contains(function ($role) {
//            return $role->name === 'role_employee';
//        });
    }
}
