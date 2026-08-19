<?php

namespace app\model;


use app\repository\ImageRepository;
use app\service\AuthService\AuthService;
use app\service\AuthService\IUser;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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
    public function saveToSession():void
    {
        $_SESSION['vitex_email_id'] = $this->getId();
    }
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function ensureAccount(): Account
    {
        if ($this->account_id && $this->relationLoaded('account')
            ? $this->account !== null
            : $this->account()->exists()) {
            return $this->account;
        }

        return DB::transaction(function () {
            $account = Account::create([
                'name' => $this->name . "'s Account",
            ]);

            $this->account_id = $account->id;
            $this->save();

            return $account;
        });
    }

    protected function rights(): Attribute
    {
        return Attribute::get(fn(string|null $rights) => !empty($rights) ? explode(',', $rights) : []);
    }

    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->using(RoleUser::class);
    }

    public function orderByUserId(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function can($rights = []): bool
    {
        $has     = $this->hasRights($rights);
        $hasRole = $this->hasRoles($rights);
        $su      = AuthService::isSU();
        $admin   = AuthService::userIsAdmin();
        return ($has || $su || $admin || $hasRole);
    }

    public function hasRoles(array $rights): bool
    {
        foreach ($rights as $right) {
            if (str_starts_with($right, 'role_')) {
                if (!!AuthService::getUser()->role->firstWhere('name', $right) === false) return false;
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
            ? ImageRepository::getImg(PIC_SERVICE . "main/ava_female.jpg")
            : ImageRepository::getImg(PIC_SERVICE . "main/ava_male.png");
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
        return $this->mail() === env('EMAIL_OLYA');
    }

    public
    function isSU(): bool
    {
        return env('EMAIL_SU') === $this->mail();
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
    }
}
