<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $primaryKey = 'registration_id';

    protected $fillable = [
        'user_id', 'event_id', 'status', 'qr_code', 'checked_in',
        'checked_in_at', 'certificate_generated', 'questionnaire_completed',
    ];

    protected function casts(): array
    {
        return [
            'checked_in' => 'boolean',
            'certificate_generated' => 'boolean',
            'questionnaire_completed' => 'boolean',
            'checked_in_at' => 'datetime',
            'registered_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }
}
