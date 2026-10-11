<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'company_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function shortUrls()
    {
        return $this->hasMany(ShortUrl::class);
    }

    // Helpers
    public function hasRole($name)
    {
        return $this->role && strcasecmp($this->role->name, $name) === 0;
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('SuperAdmin');
    }

    public function isAdmin()
    {
        return $this->hasRole('Admin');
    }

    public function isMember()
    {
        return $this->hasRole('Member');
    }

    // Mutator to hash password when set
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }
}
