<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;

    protected $primaryKey = 'agency_id';

    protected $fillable = [
        'agency_name', 'agency_code', 'address', 'contact', 'email',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'agency_id', 'agency_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'agency_id', 'agency_id');
    }
}
