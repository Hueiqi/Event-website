<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $primaryKey = 'event_id';

    protected $fillable = [
        'category_id', 'agency_id', 'organizer_id', 'title', 'description',
        'date', 'time', 'venue', 'capacity', 'status',
    ];

    protected function casts(): array
    {
        return ['date' => 'date'];
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class, 'agency_id', 'agency_id');
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id', 'user_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'event_id', 'event_id');
    }

    public function materials()
    {
        return $this->hasMany(PresentationMaterial::class, 'event_id', 'event_id');
    }

    public function isFull(): bool
    {
        return $this->registrations()->where('status', '!=', 'cancelled')->count() >= $this->capacity;
    }
}
