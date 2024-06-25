<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Constants\UserRole;
use App\Models\Concerns\HasUuid;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasName
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        HasUuid,
        SoftDeletes,
        HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'country',
        'postal_code',
        'birthdate',
        'password',
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
        'birthdate' => 'date:d-m-Y',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getFilamentName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail()
        // TODO CHANGE RULE
        return $this->hasRole(Utils::getSuperAdminName()) ||
            $this->hasRole(Utils::getPanelUserRoleName()) ||
            $this->hasRole(UserRole::ADMIN) ||
            $this->hasRole(UserRole::DOGME_USER);
    }

    /**
     * Get the talent associated with the user.
     */
    public function talent(): HasOne
    {
        return $this->hasOne(Talent::class);
    }
}
