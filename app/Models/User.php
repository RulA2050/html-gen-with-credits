<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone_number',
        'points',
        'phone_verified_at',
        'phone_verification_code',
        'phone_verification_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'phone_verification_code',
    ];

    protected $casts = [
        'email_verified_at'             => 'datetime',
        'phone_verified_at'             => 'datetime',
        'phone_verification_expires_at' => 'datetime',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'ADMIN';
    }

    public function topups()
    {
        return $this->hasMany(TopupTransaction::class);
    }

    public function generations()
    {
        return $this->hasMany(HtmlGeneration::class);
    }
}
