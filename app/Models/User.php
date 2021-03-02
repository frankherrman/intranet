<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    /**
     * Make sure we only load the permissions once per request
     *
     * @var array
     */
    protected $permission_cache = [];

    /**
     * Relation with permissions
     *
     * @return hasMany
     */
    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Get array of permissions, returns all permissions in case of admin
     *
     * @return array
     */
    public function getPermissions() {
        if(!empty($this->permission_cache)) {
            return $this->permission_cache;
        }
        $this->permission_cache = $this->permissions()->get()->pluck('key', 'id')->toArray();
        
        if(in_array('ADMIN', $this->permission_cache)) {
            $this->permission_cache = Cache::remember('all_permissions_list', 10, function() {
                return Permission::all()->pluck('key', 'id')->toArray();
            });
        }
        
        return $this->permission_cache;
    }

    /**
     * Check if user has a specific permission
     *
     * @param [type] $permission
     * @return boolean
     */
    public function hasPermission($permission) {
        $permissions = $this->getPermissions();
        return in_array($permission, $permissions);
    }
}
