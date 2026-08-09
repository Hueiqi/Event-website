<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'agency_id', 'name', 'email', 'password', 'role', 'user_type', 'mykad',
        'avatar', 'notification_preferences',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'notification_preferences' => 'array',
        ];
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class, 'agency_id', 'agency_id');
    }

    public function organizedEvents()
    {
        return $this->hasMany(Event::class, 'organizer_id', 'user_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'user_id', 'user_id');
    }

    public function uploadedMaterials()
    {
        return $this->hasMany(PresentationMaterial::class, 'uploaded_by', 'user_id');
    }

    // Role helpers
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isAgencyAdmin(): bool { return $this->role === 'agency_admin'; }
    public function isOrganizer(): bool { return $this->role === 'organizer'; }
    public function isParticipant(): bool { return $this->role === 'participant'; }
}
