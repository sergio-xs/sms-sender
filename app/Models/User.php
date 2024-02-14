<?php

namespace App\Models;

use App\Notifications\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'web';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'gsm_permissions'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Table attribute
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Datatable action buttons
     *
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return ' <div class="dropdown">
                       <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                           <i data-feather="more-vertical"></i>
                       </button>
                       <div class="dropdown-menu dropdown-menu-end">
                           <button class="dropdown-item gsmBoxBtn" data-toggle="modal">
                               <i data-feather="box" class="me-50"></i>
                               <span>'.__('users.datatable.columns.gsm_box_btn').'</span>
                           </button>
                           <button class="dropdown-item editUser" data-toggle="modal">
                               <i data-feather="edit-2" class="me-50"></i>
                               <span>'.__('users.datatable.columns.edit_btn').'</span>
                           </button>
                           <button class="dropdown-item deleteUser">
                               <i data-feather="trash" class="me-50"></i>
                               <span>'.__('users.datatable.columns.delete_btn').'</span>
                           </button>
                       </div>
                  </div>';
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Create a new personal access token for the user.
     *
     * @param  string  $name
     * @param  array  $abilities
     * @param  \DateTimeInterface|null  $expiresAt
     * @return \Laravel\Sanctum\NewAccessToken
     */
    public function createToken(string $name, array $abilities = ['*'], DateTimeInterface $expiresAt = null)
    {
        $permissions = $this->permissions->pluck('name');
        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => $permissions,
            'expires_at' => now()->addMinute(30),
        ]);

        return new NewAccessToken($token, $token->getKey().'|'.$plainTextToken);
    }

    /** Assign role from specific guard
     *
     * @param $roles
     * @param string|null $guard
     * @return $this
     */
    public function assignRole($roles, string $guard = null)
    {
        $roles = \is_string($roles) ? [$roles] : $roles;
        $guard = $guard ? : $this->getDefaultGuardName();

        $roles = collect($roles)
            ->flatten()
            ->map(function ($role) use ($guard) {
                return $this->getStoredRole($role, $guard);
            })
            ->all();

        $this->roles()->saveMany($roles);

        $this->forgetCachedPermissions();

        return $this;
    }

    /** Store role
     *
     * @param $role
     * @param string $guard
     * @return Role
     */
    protected function getStoredRole($role, string $guard): Role
    {
        if (\is_string($role)) {
            return app(Role::class)->findByName($role, $guard);
        }

        return $role;
    }


    /**
     * Grant the given permission(s) to a role.
     *
     * @param string|int|array|\Spatie\Permission\Contracts\Permission|\Illuminate\Support\Collection $permissions
     *
     * @return $this
     */
    public function givePermissionTo($permissions, string $guard = null)
    {
        $permissions = \is_string($permissions) ? [$permissions] : $permissions;
        $guard = $guard ? : $this->getDefaultGuardName();

        $permissions = collect($permissions)
            ->flatten()
            ->map(function ($permissions) use ($guard) {
                return $this->getStoredPermission($permissions, $guard);
            })
            ->all();

        $this->permissions()->saveMany($permissions);

        $this->forgetCachedPermissions();

        return $this;
    }

    /** Store permission
     * @param $role
     * @param string $guard
     * @return Role
     */
    protected function getStoredPermission($permission, string $guard): Permission
    {
        if (\is_string($permission)) {
            return app(Permission::class)->findByName($permission, $guard);
        }

        return $permission;
    }

}
