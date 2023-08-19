<?php

namespace App\Models\FrontModels;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
// use Althinect\FilamentSpatieRolesPermissions\Concerns\HasSuperAdmin;


class Newsletters extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    // use HasSuperAdmin;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
       'newsletters_email',
       'newsletters_firstname',
       'newsletters_lastname',
       'newsletters_function',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    protected $hidden = [
        // 'password',
        // 'remember_token',
    ];

    protected $guard= 'web';

    // protected $roles = [
    //     'roles',
    // ];
        
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'contact_verified_at' => 'datetime',
    ];
}
