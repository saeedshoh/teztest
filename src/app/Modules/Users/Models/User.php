<?php namespace App\Modules\Users\Models;

use App\Modules\Shops\Models\Shop;

use App\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use Notifiable;
    use HasFactory;
    use HasApiTokens;
    use HasProfilePhoto;
    use HasRoles;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    use TwoFactorAuthenticatable;

    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_INACTIVE = 'INACTIVE';
    public const STATUS_INVISIBLE = 'INVISIBLE';

    public const STATUSES_ARRAY = [
        self::STATUS_ACTIVE => 'Активный',
        self::STATUS_INACTIVE => 'Заблокирован',
        self::STATUS_INVISIBLE => 'Скрытый'
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'shop_id', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function getPermissionsAttribute() {
        $permissions = \Cache::rememberForever('permissions_cache', function() {
            return Permission::select('permissions.*', 'model_has_permissions.*')
                ->join('model_has_permissions', 'permissions.id', '=', 'model_has_permissions.permission_id')
                ->get()->collect();
        });

        return $permissions->where('model_id', $this->id);
    }

    public function getRolesAttribute() {
        $roles = \Cache::remember('roles_cache', config("cache.stores.cache_ttl_default"), function () {
        return Role::select('roles.*', 'model_has_roles.*')
                ->join('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->get()->collect();
        });

        return $roles->where('model_id', $this->id);
    }

    /**
     * @return array
     */
    public function getRoleListAttribute()
    {
        $roles = Cache::remember('users:' . $this->id . ':roles_id', 10, function () {
            return $this->roles->pluck('id', 'id')->toArray();
        });

        return $roles;
    }

    /**
     * @return array
     */
    public function getPermissionListAttribute()
    {
        $perm = Cache::remember('users:' . $this->id . ':permissions_id', 10, function () {
            return $this->permissions->pluck('id', 'id')->toArray();
        });

        return $perm;
    }
}
