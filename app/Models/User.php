<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'middle_name',
        'last_name',
        'email',
        'secondary_email',
        'role',
        'password',
        'program_name',
        'team_name',
        'team_head',
        'team_head_phone',
        'parent_name',
        'child_name',
        'grade',
        'gender',
        'member',
        'phone_home',
        'mobile',
        'address1',
        'address2',
        'city',
        'state',
        'zip',
        'country',
        'company',
        'status',
        'email_sent',
        'csv_sent',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
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
        'password' => 'hashed',
        'member' => 'boolean',
        'status' => 'boolean',
        'email_sent' => 'boolean',
        'csv_sent' => 'boolean',
    ];

    /**
     * Determine if the user can access the Filament panel.
     *
     * @param Panel $panel
     * @return bool
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Only run the check in the production environment
        if (app()->environment('production') && $panel->getId() === 'admin') {
            return str_ends_with($this->email, '@artworkwebsite.com') && $this->hasVerifiedEmail();
        }

        // Allow access in non-production environments (e.g., local, staging)
        return true;
    }


    /**
     * Get the businesses owned by the user.
     */
    public function businesses()
    {
        return $this->hasMany(Business::class);
    }

}
